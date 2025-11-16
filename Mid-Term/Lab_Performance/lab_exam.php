<!DOCTYPE html>
<html>
<head>
    <title>Student Registration & Course Selector</title>
    <link rel="stylesheet" href="Style.css">
</head>

<body>
    <center>
    <h2>Student Registration</h2>

    <div class="box">
        <label>Full Name:</label><br>
        <input type="text" id="name"><br>

        <label>Email:</label><br>
        <input type="text" id="email"><br>

        <label>Password:</label><br>
        <input type="password" id="pass"><br>

        <label>Confirm Password:</label><br>
        <input type="password" id="cpass"><br>

        <button onclick="registration()">Register</button>

        <div id="result" class="success-box"></div>
    </div>

    <h2>Course Selection</h2>

    <div class="box">
        <input type="text" id="courseInput" placeholder="Enter Course Name">
        <button onclick="addCourse()">Add Course</button>

        <div id="courseList"></div>
    </div>

    <script src="script.js"></script>
</center>
</body>
</html>
