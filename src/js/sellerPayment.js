document.addEventListener('DOMContentLoaded', async () => {
    // Check if MetaMask is installed
    if (window.ethereum) {
        window.web3 = new Web3(window.ethereum);

        try {
            // Request account access if needed
            await window.ethereum.enable();
        } catch (error) {
            console.error('Access to the wallet denied:', error);
            alert('Access to the wallet denied. Please grant access in MetaMask settings.');
        }
    } else if (window.web3) {
        window.web3 = new Web3(window.web3.currentProvider);
    } else {
        console.error('No Ethereum provider detected. Install MetaMask or use a browser with Ethereum support.');
        alert('No Ethereum provider detected. Please install MetaMask or use a compatible browser.');
    }

    // Automatically fill the sender's address field with the current MetaMask address
    const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
    const fromAddressInput = document.getElementById('fromAddress');
    fromAddressInput.value = accounts[0];
});
async function sendEther() {
    const fromAddressInput = document.getElementById('fromAddress');
    const toAddressInput = document.getElementById('toAddress');
    const amountInput = document.getElementById('amount');

    const fromAddress = fromAddressInput.value;
    const toAddress = toAddressInput.value;
    const amount = amountInput.value;

    try {
        if (!amount) {
            throw new Error('Please fill in all required fields.');
        }

        const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
        const fromAccount = accounts[0];

        if (!fromAccount) {
            throw new Error('No account selected. Please connect your wallet and try again.');
        }

        // Send Ether
        const result = await window.web3.eth.sendTransaction({
            from: fromAccount,
            to: toAddress,
            value: window.web3.utils.toWei(amount, 'ether'),
        });

        console.log('Transaction Hash:', result.transactionHash);
        alert('Ether sent successfully!');
        
        // Clear input fields after successful transaction
        amountInput.value = '';
    } catch (error) {
        console.error('Error sending Ether:', error.message);
        alert('Error sending Ether. Check the console for details.');
    }
}
