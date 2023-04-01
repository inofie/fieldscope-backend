<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Fourth Page</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        .page4-header-fcol > p {
            font-size: 2.5rem;
            text-transform: uppercase;
            line-height: 0.5;
            margin-left: 4rem;
            color: rgb(73,73,75);
        }
        .page4-header-fcol {
            position: relative;
        }
        .page4-header-fcol .page4-head-dynamic-text{
            margin: 2rem 0 0 4rem;
        }
        .page4-head-dynamic-text::before {
            content: "04";
            left: 10.25%;
            top: 80%;
            position: absolute;
            color: rgb(73,73,75);
                }
        .page4-head-dynamic-text::after {
            content: "";
            left: -17%;
            top: 83%;
            height: 3px;
            width: 26%;
            background: rgb(138,186,43);
            position: absolute;
        }
        .page4-header-scol > img {
            width: 480px;
            height: 120px;
            margin: 4rem 0 0 0;
        }
        table {
            margin: auto;
        }
        .page4-inspection > p {
            margin-top: 5rem;
            font-size: 2.5rem;
            text-transform: uppercase;
            color: rgb(73,73,75);
        }
        .page4-question > p {
            color: rgb(73,73,75);
            margin-left: 2.5rem;
        }
        .page4-answer > p {
            color: rgb(73,73,75);
            margin-right: 5rem;
        }
        .page4-answer {
            text-align: right;
        }
        
        .page4-footer-heading > p {
            color: rgb(88,90,90);
            font-size: 3rem;
            font-weight: bold;
            margin: 5rem 0 1rem 2rem;
        }
        .page4-footer-text > p {
            color: rgb(88,90,90);
            font-size: 2rem;
        }
        .page4-footer-text {
            margin-top: 1rem;
        }
        .page4-footer-text .page4-footertext-floatleft {
            width: 25%;
            line-height: 1.125;
            display: block;
            float: left;
            margin-right: 4rem;
        } 
        .page4-footer-text > h1 {
            color: rgb(88,90,90);
            font-size: 3rem;
            font-weight: bold;
            margin: 5rem 0 1.5rem 0;
        }
        .page4-footer-hr > hr {
            margin: 0 auto;
            border-top: 5px solid rgb(176,210,76);
            margin-top: 1rem;
        }
        .page4-footer-logo > p {
            display: inline-block;
            color: rgb(162,162,163);
            font-size: 2rem;
            margin-right: 1rem;
            margin-top: 1.25rem;
            margin-bottom: 8rem;
        }
        .page4-footer-logo > img {
            height: 30px;
            width: 150px;
            margin-right: 3rem;
            vertical-align: sub;
            margin-top: 1rem;
        }
        
    </style>
</head>
<body>
    <table width=90% >
        <thead>
            <tr>
                <td class="page4-header-fcol">
                    <p>Emerson Enterprises</p>
                    <p class="page4-head-dynamic-text">Inspection Details</p>
                </td>
                <td align=right class="page4-header-scol">
                    <img src="{{asset('assets/images/pdf-logo-new.png')}}" alt="header logo" >
                </td>
                
            </tr>
           
        </thead>
       
        <tbody>
            <tr>
                <td class="page4-inspection" colspan=2>
                   <p>roof Inspection</p> 
                </td>
            </tr>
            <tr>
                <td class="page4-question" colspan=1>
                    <p>Does the roof have asphalt shingles installed ?</p>                    
                </td>  
                <td class="page4-answer" colspan=1>
                    <p>yes</p>                    
                </td>             
            </tr>
            <tr>
                <td class="page4-question" colspan=1>
                    <p>Does the roof have ice and water Shield installed ?</p>                    
                </td>  
                <td class="page4-answer" colspan=1>
                    <p>yes</p>                    
                </td>             
            </tr>
            <tr>
                <td class="page4-question" colspan=1>
                    <p>How many layer are on the roof ?</p>                    
                </td>  
                <td class="page4-answer" colspan=1>
                    <p>1</p>                    
                </td>             
            </tr>
            <tr>
                <td class="page4-question" colspan=1>
                    <p>Does the roof have rake matel installed ?</p>                    
                </td>  
                <td class="page4-answer" colspan=1>
                    <p>no</p>                    
                </td>             
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td class="page4-footer-text" colspan=2>                
                    <h1>Project Name</h1> 
                </td>                  
            </tr>     
            <tr>
                <td class="page4-footer-text" colspan=2>                
                    <p class="page4-footertext-floatleft"> 12345 Test Street Kansas City, Missouri 64131 </p>
                    <p class="page4-footertext-floatright">Claim#123456789 <br/> <span>Location Lat:40.4, Long: -73.98</span></p>
                </td>
            </tr>  
            
            <tr>
                <td colspan=2 class="page4-footer-hr">
                    <hr>
                </td>             
            </tr>
            <tr>
                <td colspan=2 align=right class="page4-footer-logo">
                    <p>Powered By:</p> 
                    <img  src="{{asset('assets/images/pdf-footer-logo.png')}}" alt="footer logo" >
                </td>
                 
            </tr>
        </tfoot>
    </table>
    
</body>
</html>