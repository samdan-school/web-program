function getXMLHttpRequest() {
    var request, err;
    try {
        request = new XMLHttpRequest(); // Firefox, Safari, Opera, etc.
    } catch (err) {
        try { // first attempt for Internet Explorer
            request = new ActiveXObject("MSXML2.XMLHttp.6.0");
        } catch (err) {
            try { // second attempt for Internet Explorer
                request = new ActiveXObject("MSXML2.XMLHttp.3.0");
            } catch (err) {
                request = false; // oops, can’t create one!
            }
        }
    }
    return request;
}

function checkUser_id(user_id) {
    if (user_id.trim().length < 4) {
        return;
    }
    var user_id_req = document.getElementById("user_id_req");
    var ajaxRequest = getXMLHttpRequest();
    var requestUrl = '/ajax.php?user_id=' + user_id + '&rand=';

    if (ajaxRequest) {
        var myRand = parseInt(Math.random() * 999999999999999);
        ajaxRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                user_id_req.innerHTML = this.responseText;
            } else {
                return;
            }
        };
        ajaxRequest.open('GET', requestUrl + myRand, true);
        ajaxRequest.send(null);
    }
}

function getLessonEnrolled(user_id) {
    // ex 7 - 2.1
    var coursesTable = document.getElementById("courses-table");
    var tableText = '';
    var ajaxRequest = getXMLHttpRequest();
    var selectedCourses = [];
    var requestUrl = '/ajax.php';

    if (ajaxRequest) {
        ajaxRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var returnJSON = JSON.parse(this.responseText);
                var course_enrollments = returnJSON.course_enrollments;
                var courses = returnJSON.courses;

                course_enrollments.forEach((enrolled_course) => {
                    courses.filter((course) => {
                        if (course['course_id'] == enrolled_course['course_id']) {
                            selectedCourses.push(course['course_id']);
                            tableText += `
                            <tr class="table-success">
                                <th scope="row">${course["course_id"]}</th>
                                <td>${course["course_name"]}</td>
                                <td>${course["credit"]}</td>
                                <td><input name="courses[]" checked type="checkbox" value="${course["course_id"]}" />
                            </tr>`;
                        }
                    });
                });

                courses.forEach((course) => {
                    if (!selectedCourses.includes(course['course_id'])) {
                        tableText += `
                            <tr>
                                <th scope="row">${course["course_id"]}</th>
                                <td>${course["course_name"]}</td>
                                <td>${course["credit"]}</td>
                                <td><input name="courses[]" type="checkbox" value="${course["course_id"]}" />
                            </tr>`;
                    }
                });
                coursesTable.innerHTML = tableText;

                // ex 7 - 2.2        
                var confirm = document.getElementById('confirm');
                confirm.addEventListener('click', () => {
                    confirmLesson(user_id, selectedCourses);
                });

            } else {
                return;
            }
        };
        ajaxRequest.open('POST', requestUrl, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send('student_id=' + user_id);
    }
}

function getProgramCourse(user_id) {
    // ex 7 - 2.1
    var coursesTable = document.getElementById("courses-table");
    var tableText = '';
    var ajaxRequest = getXMLHttpRequest();
    var selectedCourses = [];
    var requestUrl = '/ajax.php';

    if (ajaxRequest) {
        ajaxRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var data = this.responseXML;
                var course_enrollments = data.getElementsByTagName('course_enrollments')[0].getElementsByTagName('course_id');
                var courses = data.getElementsByTagName('courses')[0].getElementsByTagName('course');

                console.log();

                Array.from(course_enrollments).forEach((enrolled) => {
                    selectedCourses.push(enrolled.textContent);
                });

                Array.from(courses).forEach((course) => {
                    var course_id = course.getElementsByTagName('course_id')[0].textContent;
                    var course_name = course.getElementsByTagName('course_name')[0].textContent;
                    var credit = course.getElementsByTagName('credit')[0].textContent;
                    if (selectedCourses.includes(course_id)) {
                        tableText += `
                            <tr class="table-success">
                                <th scope="row">${course_id}</th>
                                <td>${course_name}</td>
                                <td>${credit}</td>
                                <td><input name="courses[]" checked type="checkbox" value="${course_id}" />
                            </tr>`;
                    } else {
                        tableText += `
                            <tr>
                                <th scope="row">${course_id}</th>
                                <td>${course_name}</td>
                                <td>${credit}</td>
                                <td><input name="courses[]" type="checkbox" value="${course_id}" />
                            </tr>`;
                    }
                });
                coursesTable.innerHTML = tableText;
            } else {
                return;
            }
        };
        ajaxRequest.open('POST', requestUrl, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send('student_id=' + user_id + '&xml=true');
    }
}

function confirmLesson(user_id, selectedCourses) {
    var confirmInfo = {
        [user_id]: selectedCourses,
    };

    var confirmBox = document.getElementById('confirm_box');
    var ajaxRequest = getXMLHttpRequest();
    var requestUrl = '/ajax.php';

    if (ajaxRequest) {
        ajaxRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                confirmBox.innerHTML = this.responseText;
            } else {
                return;
            }
        };
        ajaxRequest.open('POST', requestUrl, true);
        ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajaxRequest.send('confirm=' + JSON.stringify(confirmInfo));
    }
}
