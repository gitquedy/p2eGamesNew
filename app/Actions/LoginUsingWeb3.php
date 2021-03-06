<?php

namespace App\Actions;

use App\Models\User;
use Elliptic\EC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use kornrunner\Keccak;

class LoginUsingWeb3
{
    public function __invoke(Request $request)
    {
        if (! $this->authenticate($request)) {
            throw ValidationException::withMessages([
                'signature' => 'Invalid signature.'
            ]);
        }
        if (Auth::check()) {
            $user = Auth::user();
            $user->eth_address = $request->address;
            $user->save();
        }
        else {
            Auth::login(User::firstOrCreate(
                ['eth_address' => $request->address]
            ));
        }
        return response()->json(['user' => Auth::user(), 'redirect' => Session::get('url.intended')]);
        // return Redirect::route('home.index');
    }

    protected function authenticate(Request $request): bool
    {
        return $this->verifySignature(
            $request->message,
            $request->signature,
            $request->address,
        );
    }

    protected function verifySignature($message, $signature, $address): bool
    {
        $messageLength = strlen($message);
        $hash = Keccak::hash("\x19Ethereum Signed Message:\n{$messageLength}{$message}", 256);
        $sign = [
            "r" => substr($signature, 2, 64),
            "s" => substr($signature, 66, 64)
        ];

        $recId  = ord(hex2bin(substr($signature, 130, 2))) - 27;

        if ($recId != ($recId & 1)) {
            return false;
        }

        $publicKey = (new EC('secp256k1'))->recoverPubKey($hash, $sign, $recId);

        return $this->pubKeyToAddress($publicKey) === Str::lower($address);
    }

    protected function pubKeyToAddress($publicKey): string
    {
        return "0x" . substr(Keccak::hash(substr(hex2bin($publicKey->encode("hex")), 1), 256), 24);
    }
}
