function registration() {
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let pass = document.getElementById("pass").value;
    let cpass = document.getElementById("cpass").value;

    if (name === "" || email === "" || pass === "" || cpass === "") {
        alert("All fields are required!");
        return;     
    }

    if (!email.includes("@")) {
        alert("Enter valid E-mail");
        return;
    }

    if (pass !== cpass) {
        alert("Passwords do not match!");
        return;
    }

    document.getElementById("result").innerHTML =
        "Registration Successful!<br>" +
        "Details: <br><br>"+
        "Name: " + name + "<br>" +
        "Email: " + email;
}

function addCourse() {
    let courseName = document.getElementById("courseInput").value;

    if (courseName === "") {
        alert("Please enter a course name!");
        return;
    }

    let courseList = document.getElementById("courseList");

    let div = document.createElement("div");
    div.className = "course-item";

    div.innerHTML = `
        ${courseName}
        <button onclick="this.parentElement.remove()">Delete</button>
    `;

    courseList.appendChild(div);

    document.getElementById("courseInput").value = "";
}
