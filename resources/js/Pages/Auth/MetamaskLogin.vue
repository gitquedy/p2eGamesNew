<template>
    <div>
        <div class="text-center pt-4 pb-8 border-b border-gray-200">
            <jet-button @click="loginWeb3">
                Login with MetaMask
            </jet-button>
        </div>
        <div class="py-6 text-sm text-gray-500 text-center">
            or login with your credentials…
        </div>
    </div>
</template>
<script>
    import Web3 from 'web3/dist/web3.min.js'
    import { useForm } from '@inertiajs/inertia-vue3'
    import JetButton from '@/Jetstream/Button.vue'
    export default  {
        components : {
            JetButton,
        },
        methods : {
        async loginWeb3() {
               if (! window.ethereum) {
                    alert('MetaMask not detected. Please try again from a MetaMask enabled browser.')
                }

                const web3 = new Web3(window.ethereum);

                const message = [
                    "I have read and accept the terms and conditions (https://example.org/tos) of this app.",
                    "Please sign me in!"
                ].join("\n")

                const address = (await web3.eth.requestAccounts())[0]
                const signature = await web3.eth.personal.sign(message, address)

                return useForm({ message, address, signature }).post('/login-web3') // Our Meta Mask integration goes here
            }
        }
    }
</script>
