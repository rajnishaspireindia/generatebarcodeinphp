<html>
<head>
<title>How to Create Barcode Generator using PHP</title>
<style>
body {
    width: 550px;
    font-family: Arial;
    font-size: 0.95em;
    color: #212121;
}

#frmBarcodeGenerator {
    padding: 30px;
    border: #E0E0E0 1px solid;
    border-radius: 3px;
}

.input-field {
    padding: 10px;
    border: #E0E0E0 1px solid;
    border-radius: 3px;
    width: 250px;
    margin: 6px 0px 8px 0px;
}

.submit-button {
    background: #ff6a00;
    border: #f16501 1px solid;
    color: #FFF;
    padding: 10px 20px;
    border-radius: 3px;
    margin-top: 8px;
}

.form-row {
    margin-bottom: 15px;
}

.result-heading {
    padding: 10px 0px 2px 0px;
    border-bottom: #333 1px solid;
    margin-bottom: 20px;
}

#validation-info {
    display: none;
    padding: 10px 20px;
    background: #f5c7c8;
    border: #e6bbbd 1px solid;
    border-radius: 3px;
}
</style>
</head>
<body>
    <form method="post" name="frmBarcodeGenerator" id="frmBarcodeGenerator"
        onSubmit="return validate();">
        <div class="form-row">
            MRP:
            <div><input type="text" name="mrp"
                id="mrp" class="input-field" /></div>
        </div>
        <div class="form-row">
            MFG Date: 
            <div><input type="date" name="mfg_date"
                id="mfg_date" class="input-field" /></div>
        </div>
        <div class="form-row">
            EXP Date: 
            <div><input type="date" name="exp_date"
                id="exp_date" class="input-field" /></div>
        </div>

        <div>
            <input type="submit" name="generate" class="submit-button"
                value="Generate Barcode" />
        </div>
    </form>  
    
    <div id="validation-info"></div>
    <script src="jquery-3.2.1.min.js"></script>
    <script>
    function validate() {
    	var valid = true;
        var message;
    	    
        $("#validation-info").hide();
    	$("#validation-info").html();
        if($("#mrp").val() == "") {
            message = "All fields are required";
            	valid = false;
        } else if(!$.isNumeric($("#mrp").val())) {
            	message = "MRP should be in numbers";
            	valid = false;
        } else if($("#mfg_date").val() == "") {
            message = "All fields are required";
            	valid = false;
        } else if($("#exp_date").val() == "") {
                message = "All fields are required";
                valid = false;
        }
        if(valid == false) {
        	   $("#validation-info").show();
           $("#validation-info").html(message);
        }
        return valid;
    }
</script>
</body>
</html>
<?php
if (! empty($_POST["generate"])) {
    require ('vendor/autoload.php');
    $barcode = new \Com\Tecnick\Barcode\Barcode();
    $targetPath = "barcode/";
    
    if (! is_dir($targetPath)) {
        mkdir($targetPath, 0777, true);
    }
    $MRP = $_POST["mrp"];
    $MFGDate = strtotime($_POST["mfg_date"]);
    $EXPDate = strtotime($_POST["exp_date"]);
    $productData = "098{$MRP}10{$MFGDate}55{$EXPDate}";
    $barcode = new \Com\Tecnick\Barcode\Barcode();
    $bobj = $barcode->getBarcodeObj('C128C', "{$productData}", 450, 70, 'black', array(0, 0, 0, 0));
    
    
    $imageData = $bobj->getPngData();
    $timestamp = time();
    
    file_put_contents($targetPath . $timestamp . '.png', $imageData);
    ?>
<div class="result-heading">Output:</div>
<img src="<?php echo $targetPath . $timestamp ; ?>.png" >
<br>
<a href='<?php echo $targetPath . $timestamp ; ?>.png' download>Download Now</a>
<?php
}
?>