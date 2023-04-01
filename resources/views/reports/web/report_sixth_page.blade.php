<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Sixth Page</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        .page6-header-fcol > p {
            font-size: 2.5rem;
            text-transform: uppercase;
            line-height: 0.5;
            margin-left: 4rem;
            color: rgb(73,73,75);
            
        }
        .page6-header-fcol {
            position: relative;
        }
        .page6-header-fcol .page6-head-dynamic-text{
            margin: 2rem 0 10rem 4rem;
        }
        .page6-head-dynamic-text::before {
            content: "06";
            left: 10.25%;
            top: 49%;
            position: absolute;
            color: rgb(73,73,75);
                }
        .page6-head-dynamic-text::after {
            content: "";
            left: -17%;
            top: 52%;
            height: 3px;
            width: 26%;
            background: rgb(138,186,43);
            position: absolute;
        }
        .page6-header-scol > img {
            width: 480px;
            height: 120px;
            margin: 4rem 0 10rem 0;
        }
        table {
            margin: auto;
        }
        .page6-inspection > p {
            margin-top: 5rem;
            font-size: 2.5rem;
            text-transform: uppercase;
            color: rgb(73,73,75);
        }        
        .page6-footer-heading > p {
            color: rgb(88,90,90);
            font-size: 3rem;
            font-weight: bold;
            margin: 5rem 0 1rem 2rem;
        }
        .page6-footer-text > p {
            color: rgb(88,90,90);
            font-size: 2rem;
        }
        .page6-footer-text {
            margin-top: 1rem;
        }
        .page6-footer-text .page6-footertext-floatleft {
            width: 25%;
            line-height: 1.125;
            display: block;
            float: left;
            margin-right: 4rem;
        } 
        .page6-footer-text > h1 {
            color: rgb(88,90,90);
            font-size: 3rem;
            font-weight: bold;
            margin: 5rem 0 1.5rem 0;
        }
        .page6-footer-hr > hr {
            margin: 0 auto;
            border-top: 5px solid rgb(176,210,76);
            margin-top: 1rem;
        }
        .page6-footer-logo > p {
            display: inline-block;
            color: rgb(162,162,163);
            font-size: 2rem;
            margin-right: 1rem;
            margin-top: 1.25rem;
            margin-bottom: 8rem;
        }
        .page6-footer-logo > img {
            height: 30px;
            width: 150px;
            margin-right: 3rem;
            vertical-align: sub;
            margin-top: 1rem;
        }
        .page6-finner-table-header,.page6-sinner-table-header {
            background: rgb(231,231,231);
        }
        .page6-finner-table-header > tr > td,
        .page6-sinner-table-header > td {
            padding-top: 1rem;
        }
        .page6-finner-table-header > tr > .first-child > p,
        .page6-sinner-table-header > .first-child > p {
            font-size: 2rem;
            text-transform: uppercase;
            font-weight: bold;
            color: rgb(70,70,72);
            margin-left: 10px ;
            letter-spacing: 2px;
        }
        .page6-finner-table-header > tr > td > p {
            color: rgb(70,70,72);
        }
        .page6-finner-table-row > td > .firstpara {
            margin: 1rem 0 0.25rem 1rem;
            font-size: 1.5rem;        
            color: rgb(70,70,72);   
        }
        .page6-finner-table-row > td > .secondpara{
            margin-left: 2.75rem;
            font-weight: bold;
            margin-bottom: 2rem;
            color: rgb(70,70,72);
        }
        .page6-finner-table-hrrow > td > hr{
            border-top: 3px solid #eee;
            margin: 0;
        }
        .page6-finner-table-finalrow > td >p {
            margin: 2rem 0 10rem 0;
            text-transform: uppercase;
            font-weight:  bold;
            color: rgb(70,70,72);

        }
    </style>
</head>
<body>
    <table width=90% >
        <thead>
            <tr>
                <td class="page6-header-fcol">
                    <p>Emerson Enterprises</p>
                    <p class="page6-head-dynamic-text">estimate</p>
                </td>
                <td align=right class="page6-header-scol">
                    <img src="{{asset('assets/images/pdf-logo-new.png')}}" alt="header logo" >
                </td>
                
            </tr>
           
        </thead>
       
        <tbody>
            <tr>
                <td class="page6-inspection" colspan=2>
                    <!-- first inner table -->
                   <table width=100%>
                       <!-- inner tables header-->
                       <thead class="page6-finner-table-header">
                           <tr >
                            <td class="first-child">
                                <p>Roofing</p>
                            </td>
                            <td>
                                <p>Qty</p>
                            </td>
                            <td>
                                <p>Uom</p>
                            </td>
                            <td>
                                <p>Material</p>
                            </td>
                            <td>
                                <p>Labour</p>
                            </td>
                            <td>
                                <p>Equipment</p>
                            </td>
                            <td>
                                <p>Supervision</p>
                            </td>
                            <td>
                                <p>Margin %</p>
                            </td>
                            <td>
                                <p>Sales Tax</p>
                            </td>
                            <td>
                                <p>Total</p>
                            </td>
                           </tr>                           
                       </thead>

                       <tbody>
                           <!-- first inner table first row-->
                           <tr class="page6-finner-table-row">
                               <td colspan=10>
                                   <p class="firstpara">R & R laminated Comp. shingles w/felt</p>
                                   <p class="secondpara">Additional note that can be applied to a tag and will show by default in annotation.</p>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=1></td>
                               <td>
                                   <p>20</p>
                               </td>
                               <td>
                                   <p>Sq.</p>
                               </td>
                               <td>
                                   <p>$100.00</p>
                               </td>
                               <td>
                                   <p>$75.00</p>
                               </td>
                               <td>
                                   <p>$200.00</p>
                               </td>
                               <td>
                                   <p>$35.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$36.67</p>
                               </td>
                               <td>
                                   <p>$667.44</p>
                               </td>
                           </tr>
                           <tr class="page6-finner-table-hrrow">
                               <td colspan=10>
                                   <hr>
                               </td>
                           </tr>
                            <!-- first inner table second row-->
                           <tr class="page6-finner-table-row">
                               <td colspan=10>
                                   <p class="firstpara">R & R laminated Comp. shingles w/felt</p>
                                   <p class="secondpara">Additional note that can be applied to a tag and will show by default in annotation.</p>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=1></td>
                               <td>
                                   <p>20</p>
                               </td>
                               <td>
                                   <p>Sq.</p>
                               </td>
                               <td>
                                   <p>$100.00</p>
                               </td>
                               <td>
                                   <p>$75.00</p>
                               </td>
                               <td>
                                   <p>$200.00</p>
                               </td>
                               <td>
                                   <p>$35.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$36.67</p>
                               </td>
                               <td>
                                   <p>$667.44</p>
                               </td>
                           </tr>
                           <tr class="page6-finner-table-hrrow">
                               <td colspan=10>
                                   <hr>
                               </td>
                           </tr>
                            <!-- first inner table third row-->
                           <tr class="page6-finner-table-row">
                               <td colspan=10>
                                   <p class="firstpara">R & R laminated Comp. shingles w/felt</p>
                                   <p class="secondpara">Additional note that can be applied to a tag and will show by default in annotation.</p>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=1></td>
                               <td>
                                   <p>20</p>
                               </td>
                               <td>
                                   <p>Sq.</p>
                               </td>
                               <td>
                                   <p>$100.00</p>
                               </td>
                               <td>
                                   <p>$75.00</p>
                               </td>
                               <td>
                                   <p>$200.00</p>
                               </td>
                               <td>
                                   <p>$35.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$36.67</p>
                               </td>
                               <td>
                                   <p>$667.44</p>
                               </td>
                           </tr>
                           <tr class="page6-finner-table-hrrow">
                               <td colspan=10>
                                   <hr>
                               </td>
                           </tr>
                            <!-- first inner table fourth row-->
                           <tr class="page6-finner-table-row">
                               <td colspan=10>
                                   <p class="firstpara">R & R laminated Comp. shingles w/felt</p>
                                   <p class="secondpara">Additional note that can be applied to a tag and will show by default in annotation.</p>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=1></td>
                               <td>
                                   <p>20</p>
                               </td>
                               <td>
                                   <p>Sq.</p>
                               </td>
                               <td>
                                   <p>$100.00</p>
                               </td>
                               <td>
                                   <p>$75.00</p>
                               </td>
                               <td>
                                   <p>$200.00</p>
                               </td>
                               <td>
                                   <p>$35.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$36.67</p>
                               </td>
                               <td>
                                   <p>$667.44</p>
                               </td>
                           </tr>
                           <tr class="page6-finner-table-hrrow">
                               <td colspan=10>
                                   <hr>
                               </td>
                           </tr>
                            <!-- first inner table fifth row-->
                           <tr class="page6-finner-table-row">
                               <td colspan=10>
                                   <p class="firstpara">R & R laminated Comp. shingles w/felt</p>
                                   <p class="secondpara">Additional note that can be applied to a tag and will show by default in annotation.</p>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=1></td>
                               <td>
                                   <p>20</p>
                               </td>
                               <td>
                                   <p>Sq.</p>
                               </td>
                               <td>
                                   <p>$100.00</p>
                               </td>
                               <td>
                                   <p>$75.00</p>
                               </td>
                               <td>
                                   <p>$200.00</p>
                               </td>
                               <td>
                                   <p>$35.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$36.67</p>
                               </td>
                               <td>
                                   <p>$667.44</p>
                               </td>
                           </tr>
                           <tr class="page6-finner-table-hrrow">
                               <td colspan=10>
                                   <hr>
                               </td>
                           </tr>
                           <!-- first inner table final row-->
                           <tr class="page6-finner-table-row page6-finner-table-finalrow">
                               <td colspan=3>
                                   <p>Roofing estimate total</p>
                               </td>
                               <td>
                                   <p>$600.00</p>
                               </td>
                               <td>
                                   <p>$450.00</p>
                               </td>
                               <td>
                                   <p>$1200.00</p>
                               </td>
                               <td>
                                   <p>$210.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$210.02</p>
                               </td>
                               <td>
                                   <p>$4,004.64</p>
                               </td>
                           </tr>

                           <!-- second inner table (header) row-->
                           <tr class="page6-sinner-table-header">
                                <td colspan=10 class="first-child">
                                    <p>guttering</p>
                                </td>
                            </tr>
                          <!-- second inner table first row-->
                            <tr class="page6-finner-table-row">
                               <td colspan=10>
                                    <p class="firstpara">R & R laminated Comp. shingles w/felt</p>
                                    <p class="secondpara">Additional note that can be applied to a tag and will show by default in annotation.</p>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=1></td>
                               <td>
                                   <p>20</p>
                               </td>
                               <td>
                                   <p>Sq.</p>
                               </td>
                               <td>
                                   <p>$100.00</p>
                               </td>
                               <td>
                                   <p>$75.00</p>
                               </td>
                               <td>
                                   <p>$200.00</p>
                               </td>
                               <td>
                                   <p>$35.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$36.67</p>
                               </td>
                               <td>
                                   <p>$667.44</p>
                               </td>
                           </tr>
                           <tr class="page6-finner-table-hrrow">
                               <td colspan=10>
                                   <hr>
                               </td>
                           </tr>
                             <!-- second inner table second row-->
                           <tr class="page6-finner-table-row">
                               <td colspan=10>
                                   <p class="firstpara">R & R laminated Comp. shingles w/felt</p>
                                   <p class="secondpara">Additional note that can be applied to a tag and will show by default in annotation.</p>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=1></td>
                               <td>
                                   <p>20</p>
                               </td>
                               <td>
                                   <p>Sq.</p>
                               </td>
                               <td>
                                   <p>$100.00</p>
                               </td>
                               <td>
                                   <p>$75.00</p>
                               </td>
                               <td>
                                   <p>$200.00</p>
                               </td>
                               <td>
                                   <p>$35.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$36.67</p>
                               </td>
                               <td>
                                   <p>$667.44</p>
                               </td>
                           </tr>
                           <tr class="page6-finner-table-hrrow">
                               <td colspan=10>
                                   <hr>
                               </td>
                           </tr>
                             <!-- second inner table third row-->
                           <tr class="page6-finner-table-row">
                               <td colspan=10>
                                   <p class="firstpara">R & R laminated Comp. shingles w/felt</p>
                                   <p class="secondpara">Additional note that can be applied to a tag and will show by default in annotation.</p>
                               </td>
                           </tr>
                           <tr>
                               <td colspan=1></td>
                               <td>
                                   <p>20</p>
                               </td>
                               <td>
                                   <p>Sq.</p>
                               </td>
                               <td>
                                   <p>$100.00</p>
                               </td>
                               <td>
                                   <p>$75.00</p>
                               </td>
                               <td>
                                   <p>$200.00</p>
                               </td>
                               <td>
                                   <p>$35.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$36.67</p>
                               </td>
                               <td>
                                   <p>$667.44</p>
                               </td>
                           </tr>
                           <tr class="page6-finner-table-hrrow">
                               <td colspan=10>
                                   <hr>
                               </td>
                           </tr>
                             <!-- second inner table final row-->
                           
                           <tr class="page6-finner-table-row page6-finner-table-finalrow">
                               <td colspan=3>
                                   <p>Roofing estimate total</p>
                               </td>
                               <td>
                                   <p>$600.00</p>
                               </td>
                               <td>
                                   <p>$450.00</p>
                               </td>
                               <td>
                                   <p>$1200.00</p>
                               </td>
                               <td>
                                   <p>$210.00</p>
                               </td>
                               <td>
                                   <p>35 %</p>
                               </td>
                               <td>
                                   <p>$210.02</p>
                               </td>
                               <td>
                                   <p>$4,004.64</p>
                               </td>
                           </tr>
                          
                       </tbody>
                   </table> 
                </td>
            </tr>            
        </tbody>

        <tfoot>
            <tr>
                <td class="page6-footer-text" colspan=2>                
                    <h1>Project Name</h1> 
                </td>                  
            </tr>     
            <tr>
                <td class="page6-footer-text" colspan=2>                
                    <p class="page6-footertext-floatleft"> 12345 Test Street Kansas City, Missouri 64131 </p>
                    <p class="page6-footertext-floatright">Claim#123456789 <br/> <span>Location Lat:40.4, Long: -73.98</span></p>
                </td>
            </tr>  
            
            <tr>
                <td colspan=2 class="page6-footer-hr">
                    <hr>
                </td>             
            </tr>
            <tr>
                <td colspan=2 align=right class="page6-footer-logo">
                    <p>Powered By:</p> 
                    <img  src="{{asset('assets/images/pdf-footer-logo.png')}}" alt="footer logo" >
                </td>
                 
            </tr>
        </tfoot>
    </table>
    
</body>
</html>