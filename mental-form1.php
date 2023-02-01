<?php 
    include("includes/header.php");
?>

<div class="mental-form">
    <div class="container">
        <div class="row">
            <form class="mentalForm" action="" method="POST" enctype="multipart/form-data">
                <h3>Form T2 - Regulation 27(2)Mental Health Act 1983 </h3>
                <h4>Section 58(3)(a) — Certificate of consent to treatment</h4>
                <div class="form-group row">
                    <p>I <input type="text" class="form-control1" id="name" placeholder="Name">, <input type="text" class="form-control1" id="address" placeholder="Address"> and, if sending by means of electronic communication, <input type="text" class="form-control1" id="email" placeholder="Email">,
                     DR <input type="text" class="form-control1" id="dr-name" placeholder="Dr Name">
                    <p>Eleanor  Independent Hospital  134 Palatine Road  Manchester M20 3ZA the approved clinician in charge of the treatment described certify that <input type="text" class="form-control1" id="name" placeholder="Name"> and <input type="text" class="form-control1" id="address" placeholder="Address">
                    <p>Eleanor Independent Hospital   134 Palatine Road  Manchester M20 3ZA (a) is capable of understanding the nature, purpose and likely effects of: Give description of treatment or plan of treatment. Indicate clearly if the certificate is only to apply to any or all of the treatment for a specific period.</p>

                    <p><input type="text" class="form-control1" id="option1" placeholder="Option">.</p>
                    <p>PRN</p>
                    <p><input type="text" class="form-control1" id="option2" placeholder="Option">.</p>
                    <p>EACH OF THE ABOVE MEDICATIONS WITHIN BNF LIMITS.</p>                                                                                                                        
                    <p>If you need to continue on a separate sheet please indicate here and attach that sheet to this form. AND (b) has consented to that treatment.</p>

                    <p><input type="text" class="form-control1" id="date" placeholder="Date"></p>      
                </div>
                <div class="text-center">
                    <input type="submit" name="SUBMIT" id="submit" class="risk-submit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php  
    include("includes/footer.php");
?>