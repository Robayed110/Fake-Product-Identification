var PayPal=artifacts.require('paypal');

module.exports=function(deployer) {
    deployer.deploy(PayPal); 
}