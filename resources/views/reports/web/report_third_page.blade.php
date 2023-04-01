<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>report_cover</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <style>
        .page3-header-fcol > p {
            font-size: 2.5rem;
            text-transform: uppercase;
            margin-left: 10rem;
            line-height: 0.5;
            color: rgb(73,73,75);
        }
        .page3-header-fcol {
            position: relative;
        }
        .page3-header-fcol .page3-head-dynamic-text{
            margin: 2rem 0 0 10rem;
        }
        .page3-head-dynamic-text::before {
            content: "03";
            left: 16.25%;
            top: 77%;
            position: absolute;
            color: rgb(73,73,75);
        }
        .page3-head-dynamic-text::after {
            content: "";
            left: -11%;
            top: 80%;
            height: 3px;
            width: 26%;
            background: rgb(138,186,43);
            position: absolute;
        }
        .page3-header-scol > img {
            width: 480px;
            height: 120px;
            margin: 4rem 0 0 0;
        }
        table {
            margin: auto;
        }
        tbody > tr > td  > img {
            width: 540px;
            height: 500px;
            margin: 8rem 3rem 1rem 3rem;
        }
        .page3-tbody-data > p {
            text-align: right;
            margin-right: 4rem;
            font-size: 2rem;
            color: rgb(73,73,75);
        }
        .page3-footer-heading > p {
            color: rgb(88,90,90);
            font-size: 3rem;
            font-weight: bold;
            margin: 5rem 0 1rem 2rem;
        }
        .page3-footer-text > p {
            color: rgb(88,90,90);
            font-size: 2rem;
            line-height: 1.125;
            margin-left: 2rem;
        }
        .page3-footer-text {
            margin-top: 1rem;
        }
        .page3-footer-text .page3-footertext-floatleft {
            width: 21%;
            line-height: 1.125;
            display: block;
            float: left;
            margin-right: 5rem;
        } 
        .page3-footer-text > h1 {
            color: rgb(88,90,90);
            font-size: 3rem;
            font-weight: bold;
            margin: 5rem 0 1.5rem 2rem;
        }
        hr {
            margin: 0 auto;
            border-top: 5px solid rgb(176,210,76);
            width: 96%;
            margin-left: 2rem;
            margin-top: 1rem;
        }
        .page3-footer-logo > p {
            display: inline-block;
            color: rgb(162,162,163);
            font-size: 2rem;
            margin-right: 1rem;
            margin-top: 1.25rem;
            margin-bottom: 8rem;
        }
        .page3-footer-logo > img {
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
                <td class="page3-header-fcol">
                    <p>Emerson Enterprises</p>
                    <p class="page3-head-dynamic-text">Additional Photos</p>
                </td>
                <td align=right class="page3-header-scol">
                    <img src="{{asset('assets/images/pdf-logo-new.png')}}" alt="header logo" >
                </td>
                
            </tr>
           
        </thead>
       
        <tbody>
            <tr>
                <td class="page3-tbody-data">
                    <img src="{{asset('assets/images/pdf-03-img.png')}}" alt="body-image" >
                    <p>Photo 1 of 4</p>
                </td>
                <td class="page3-tbody-data">
                    <img src="{{asset('assets/images/pdf-03-img.png')}}" alt="body-image" >
                    <p>Photo 2 of 4</p>
                </td>
            </tr>
            <tr>
                <td class="page3-tbody-data">
                    <img src="{{asset('assets/images/pdf-03-img.png')}}" alt="body-image" >
                    <p>Photo 3 of 4</p>
                </td>
                <td class="page3-tbody-data">
                    <img src="{{asset('assets/images/pdf-03-img.png')}}" alt="body-image" >
                    <p>Photo 4 of 4</p>
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td class="page3-footer-text" colspan=2>                
                    <h1>Project Name</h1> 
                </td>                  
            </tr>     
            <tr>
                <td class="page3-footer-text" colspan=2>                
                    <p class="page3-footertext-floatleft"> 12345 Test Street Kansas City, Missouri 64131 </p>
                    <p class="page3-footertext-floatright">Claim#123456789 <br/> <span>Location Lat:40.4, Long: -73.98</span></p>
                </td>
            </tr>  
            <tr>
                <td colspan=2>
                    <hr>
                </td>             
            </tr>
            <tr>
                <td colspan=2 align=right class="page3-footer-logo">
                    <p>Powered By:</p> 
                    <img  src="{{asset('assets/images/pdf-footer-logo.png')}}" alt="footer logo" >
                </td>
                 
            </tr>
        </tfoot>
    </table>

    
</body>
</html>