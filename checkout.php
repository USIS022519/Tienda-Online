<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://www.paypal.com/sdk/js?client-id=AeZtDApRcegDhdlHWCwTcLtiAcHPeUlpM4HSOnLfyXEhJtf-xdCHKOUDi_xF0zSgj3NiDF8QC1xGvWI8&currency=USD"></script>

</head>

<body>
    <div id="paypal-button-container"></div>

    <script>
        paypal.Buttons({
            style:{
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 100.00
                        }
                    }]
                });
            },

            onApprove: function(data, actions){
                actions.order.capture().then(function (detalles){
                   /* console.log(detalles); */
                   window.location.href="Completado.html"
                });
            },

            onCancel: function(data){
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');
    </script>
</body>

</html>