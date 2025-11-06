<!DOCTYPE html>
<html>  
    <style>
        .form-box {
            width: 550px;
            margin: 50px auto;
            padding: 30px;
            background: #e8fff8;
            border: 3px solid #008c74;
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.2);
        }
    </style>
    <body style="background-color:mediumaquamarine">
    <div class="form-box">

    <center>
        <h1>Client Patient Registration Form</h1>
        <table>
            <tr>
                <td>Enter Name:</td>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td>Enter Age:</td>
                <td><input type="number"></td>
            </tr>
            <tr>
                <td>Phone Number:</td>
                <td><input type="tel"></td>
            </tr>
            <tr>
                <td>Email Adddress:</td>
                <td><input type="email"></td>
            </tr>
            <tr>
                <td>Insurance Provider:</td>
                <td>
                    <select>
                        <option value="option1">Choose an Option</option>
                        <option value="option1">Partho</option>
                        <option value="option2">Ridwan</option>
                        <option value="option3">Tisha</option>
                    </select>
                </td>
            </tr>
        </table>

        <h2>Additional Informaltion</h2>
        <table>
            <tr>
                <td>User Name:</td>
                <td><input type="text"></td>
            </tr>
            <tr>    
                <td>Password:</td>
                <td><input type="password"></td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
                <td><input type="password"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;"><br>
                <input type="submit" value="Submit"
               style="background-color:green; padding:5px 15px; color:white;">
               </td>
            </tr>
        </table>
    </center>
    </div>
    

    </body>
</html>