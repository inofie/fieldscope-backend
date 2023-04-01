<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Second Page</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        .page8-header-fcol > p {
            font-size: 2.5rem;
            text-transform: uppercase;
            line-height: 0.5;
            color: rgb(73,73,75);
        }
        .page8-header-fcol {
            position: relative;
        }
        .page8-header-fcol .page8-head-dynamic-text{
            margin: 2rem 0 0 0;
        }
        .page8-head-dynamic-text::before {
            content: "09";
            left: -0.75%;
            top: 80%;
            position: absolute;
            color: rgb(73,73,75);
        }
        .page8-head-dynamic-text::after {
            content: "";
            left: -17%;
            top: 83%;
            height: 3px;
            width: 15%;
            background: rgb(138,186,43);
            position: absolute;
        }
        .page8-header-scol > img {
            width: 480px;
            height: 120px;
            margin: 4rem 0 0 0;
        }
        table {
            margin: auto;
        }
      
        .page8-body-message > p {
            margin-top: 10rem;
            color: rgb(70,72,72);
            text-align: justify;
        }
        .page8-footer-heading > p {
            color: rgb(88,90,90);
            font-size: 3rem;
            font-weight: bold;
            margin: 5rem 0 1rem 2rem;
            letter-spacing: 1.5px;
        }
        .page8-footer-text > p {
            color: rgb(88,90,90);
            font-size: 2rem;
            letter-spacing: 1.5px;
        }
        .page8-footer-text {
            margin-top: 1rem;
        }
        .page8-footer-text .page8-footertext-floatleft {
            width: 25%;
            line-height: 1.125;
            display: block;
            float: left;
            margin-right: 4rem;
            letter-spacing: 1.5px;
        } 
        .page8-footer-text > h1 {
            color: rgb(88,90,90);
            font-size: 3rem;
            font-weight: bold;
            margin: 5rem 0 1.5rem 0;
            letter-spacing: 1.5px;
        }
        .page8-footer-hr > hr {
            margin: 0 auto;
            border-top: 5px solid rgb(176,210,76);
            margin-top: 1rem;
        }
        .page8-footer-logo > p {
            display: inline-block;
            color: rgb(162,162,163);
            font-size: 2rem;
            margin-right: 1rem;
            margin-top: 1.25rem;
            margin-bottom: 8rem;
        }
        .page8-footer-logo > img {
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
                <td class="page8-header-fcol">
                    <p class="page8-head-para">Inspection report</p>
                    <p class="page8-head-date">June 8th 2021</p>
                </td>
                <td align=right class="page8-header-scol">
                    <img src="{{asset('assets/images/pdf-logo-new.png')}}" alt="header logo" >
                    <h1>project name</h1>
                    <p class="page8-head-floatleft"> 12345 Test Street Kansas City, Missouri 64131 </p>
                    <p class="page8-head-floatright">Claim#123456789 <br/> <span>Location Lat:40.4, Long: -73.98</span></p>
                </td>
                
            </tr>
           
        </thead>
       
        <tbody>
            
            <tr>
                <td class="page8-body-message" colspan=2>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <h1>user name</h1>
                                    <p>913-123-4567</p>
                                    <p>useremail@email.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>4590 craseview terrace <br />New braunfels, TX 78130,<br /> New York</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>887-4-EMERSON</p>
                                    <p>info@emerson-enterprises.com</p>
                                    <p>www.emerson-enterprises.com</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                   
                   <p></p>
                   

                   <p></p>
                </td>
            </tr>
        </tbody>

        <tfoot>           
            <tr>
                <td colspan=2 class="page8-footer-hr">
                    <p>roofing</p>
                </td>   
                <td colspan=2 class="page8-footer-hr">
                    <p>siding</p>
                </td>          
            </tr>
            <tr>
                <td colspan=2 class="page8-footer-hr">
                    <p>gutters</p>
                </td>   
                <td colspan=2 class="page8-footer-hr">
                    <p>insulation</p>
                </td>          
            </tr>
            <tr>
                <td colspan=2 align=right class="page8-footer-logo">
                    <p>Powered By:</p> 
                    <img  src="{{asset('assets/images/pdf-footer-logo.png')}}" alt="footer logo" >
                </td>
                 
            </tr>
        </tfoot>
    </table>
    
</body>
</html>