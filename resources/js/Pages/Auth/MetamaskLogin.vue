<template>
    <div @click="loginWeb3" id="metamaskLogin">
       <i class="me-50" data-feather="log-in"></i> Login with MetaMask
    </div>
</template>
<script>
    import Web3 from 'web3/dist/web3.min.js'

    export default  {
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

                const  params = {
                    address: address,
                    signature : signature,
                    message: message,
                };
                    axios.post('/login-web3', params)
                    .then(response => window.location.reload())
                    .catch(err => alert(err.response.data.message)
                        );


            }
        }
    }
</script>
