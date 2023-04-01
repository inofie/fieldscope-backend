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
        .page2-header-fcol > p {
            font-size: 2.5rem;
            text-transform: uppercase;
            line-height: 0.5;
            color: rgb(73,73,75);
        }
        .page2-header-fcol {
            position: relative;
        }
        .page2-header-fcol .page2-head-dynamic-text{
            margin: 2rem 0 0 0;
        }
        .page2-head-dynamic-text::before {
            content: "02";
            left: -0.75%;
            top: 80%;
            position: absolute;
            color: rgb(73,73,75);
        }
        .page2-head-dynamic-text::after {
            content: "";
            left: -17%;
            top: 83%;
            height: 3px;
            width: 15%;
            background: rgb(138,186,43);
            position: absolute;
        }
        .page2-header-scol > img {
            width: 480px;
            height: 120px;
            margin: 4rem 0 0 0;
        }
        table {
            margin: auto;
        }
        .page2-welcome-message > p {
            font-size: 4rem;
            text-transform: uppercase;
            width: 20%;
            line-height: 1.25;
            margin-top: 10rem;
            color: rgb(70,72,72);
            font-weight: 600;
        }
        .page2-company > p {
            font-size: 3rem;
            text-transform: uppercase;
            line-height: 1.25;
            margin-top: 5rem;
            font-weight: 600;
            color: rgb(70,72,72);
        }
        .page2-company .designation {
            font-size: 2rem;
            text-transform: uppercase;
            line-height: 1.25;
            font-weight: 500;
            margin-top: 0;
            color: rgb(70,72,72);
        }
        .page2-body-message > p {
            margin-top: 3rem;
            color: rgb(70,72,72);
            text-align: justify;
        }
        .page2-sig-img >  img{
            width: 350px;
            height: 200px;
            margin: 5rem;
        }
        .page2-footer-hr > hr {
            margin: 0 auto;
            border-top: 5px solid rgb(176,210,76);
            margin-top: 1rem;
        }
        .page2-footer-logo > p {
            display: inline-block;
            color: rgb(162,162,163);
            font-size: 2rem;
            margin-right: 1rem;
            margin-top: 1.25rem;
            margin-bottom: 8rem;
        }
        .page2-footer-logo > img {
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
                <td class="page2-header-fcol">
                    <p>Emerson Enterprises</p>
                    <p class="page2-head-dynamic-text">Company Introduction</p>
                </td>
                <td align=right class="page2-header-scol">
                    <img src="{{asset('assets/images/pdf-logo-new.png')}}" alt="header logo" >
                </td>
                
            </tr>
           
        </thead>
       
        <tbody>
            <tr>
                <td class="page2-welcome-message" colspan=2>
                   <p>Welcome message</p> 
                </td>
            </tr>
            <tr>
                <td class="page2-company" colspan=2>
                    <p>Paul Emerson</p>
                    <p class="designation">CEO / Founder</p>
                </td>               
            </tr>
            <tr>
                <td class="page2-body-message" colspan=2>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                        It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                    The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                        It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                    The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                        It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                    The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                    </p>
                </td>
            </tr>
            <tr>
               <td class="page2-sig-img" colspan=2 align=right>
                   <img src="{{asset('assets/images/sig.png')}}" alt="signature ">
               </td>
            </tr>
        </tbody>

        <tfoot>
            
            <tr>
                <td colspan=2 class="page2-footer-hr">
                    <hr>
                </td>             
            </tr>
            <tr>
                <td colspan=2 align=right class="page2-footer-logo">
                    <p>Powered By:</p> 
                    <img  src="{{asset('assets/images/pdf-footer-logo.png')}}" alt="footer logo" >
                </td>
                 
            </tr>
        </tfoot>
    </table>
    
</body>
</html>