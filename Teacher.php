<?php
include 'db_connection_teacher.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="Teacher.css">
</head>
<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="profile">
                <div class="profile-picture"></div>
                <div class="teacher-name">Teacher</div>
            </div>
            <nav class="menu">
                <button class="menu-item" onclick="showMainDisplay('announcements', this)">Homework Announcements</button>
                <button class="menu-item" onclick="showMainDisplay('students', this)">Student Data Management</button>
                <button class="menu-item" onclick="showMainDisplay('material', this)">Learning Material</button>
            </nav>
            <div class="sidebar-footer">
                <button class="logout" onclick="location.href='Main Private.html';">Main Page</button>
                <button class="logout" onclick="location.href='Main Page.html';">Logout</button>
            </div>
        </div>
        <div class="main-display">
            <div id="announcements" class="hidden">
                <fieldset>
                    <legend>Post Homework Announcement</legend>
                    <form class="announcement-form" method="POST">
                        <div>
                            <label for="homework-title">Homework Title:</label>
                            <input type="text" id="homework-title" name="homework-title" placeholder="Enter homework title" required> 
                        </div>

                        <div>
                            <label for="homework-deadline">Deadline:</label>
                            <input type="date" id="homework-deadline" name="homework-deadline" required>
                        </div>
                        
                        <div>
                            <label for="homework-elaboration">Elaboration:</label>
                            <textarea id="homework-elaboration" name="homework-elaboration" rows="10" placeholder="Provide detailed information about the homework" required></textarea>
                        </div>
                        
                        <button type="submit" name="postAnnouncement">Post Announcement</button>
                        <button type="reset">Clear</button>
                    </form>
                </fieldset>

                <h3>Posted Announcements</h3>
                <table id="announcements-table" class="announcements-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Posted Date</th>
                            <th>Deadline</th>
                            <th>Elaboration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['postAnnouncement'])) {
                            $homeworkTitle = $_POST['homework-title'];
                            $homeworkDeadline = $_POST['homework-deadline'];
                            $homeworkElaboration = $_POST['homework-elaboration'];

                            // Store in database or session
                            $announcements = isset($_SESSION['announcements']) ? $_SESSION['announcements'] : [];
                            $announcements[] = [
                                'title' => $homeworkTitle,
                                'posted_date' => date('Y-m-d'),
                                'deadline' => $homeworkDeadline,
                                'elaboration' => $homeworkElaboration
                            ];
                            $_SESSION['announcements'] = $announcements;
                        }

                        $announcements = isset($_SESSION['announcements']) ? $_SESSION['announcements'] : [];
                        if (count($announcements) > 0) {
                            foreach ($announcements as $key => $announcement) {
                                echo "<tr>
                                    <td>" . ($key + 1) . "</td>
                                    <td>{$announcement['title']}</td>
                                    <td>{$announcement['posted_date']}</td>
                                    <td>{$announcement['deadline']}</td>
                                    <td>{$announcement['elaboration']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No announcements yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="students" class="hidden">
                <fieldset>
                    <legend>Upload Grades & Attendance</legend>
                    <form class="student-data-form" method="POST">
                        <div>
                            <label for="student-name">Student Name :</label>
                            <input type="text" id="student-name" name="student-name" placeholder="Enter student name" required>
                        </div>
                        <div>
                            <label for="education">School Level :</label>
                            <select id="education" name="education" required>
                                <option value="" disabled selected>Select School Level</option>
                                <option value="sjkc">SJKC</option>
                                <option value="sk">SK</option>
                                <option value="secondary">Secondary</option>
                            </select>
                        </div>
                        <div>
                            <label for="subject">Subject:</label>
                            <select id="subject" name="subject" required>
                                <option value="" disabled selected>Select Subject</option>
                                <option value="math">Mathematics</option>
                                <option value="science">Science</option>
                                <option value="english">English</option>
                                <option value="history">History</option>
                            </select>
                        </div>

                        <div>
                            <label for="grade">Grade:</label>
                            <select id="grade" name="grade" required>
                                <option value="" disabled selected>Select Grade</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="FAILED">FAILED</option>
                            </select>
                        </div>

                        <div>
                            <label for="attendance">Attendance:</label>
                            <input type="text" id="attendance" name="attendance" placeholder="Enter Percentage of Attendance" required>
                        </div>

                        <button type="submit" name="uploadStudentData">Save</button>
                        <button type="reset">Clear</button>
                    </form>
                </fieldset>

                <h3>Student Data Records</h3>
                <table id="students-table" class="students-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Student Name</th>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['uploadStudentData'])) {
                            $studentName = $_POST['student-name'];
                            $education = $_POST['education'];
                            $subject = $_POST['subject'];
                            $grade = $_POST['grade'];
                            $attendance = $_POST['attendance'];

                            // Store in database or session
                            $students = isset($_SESSION['students']) ? $_SESSION['students'] : [];
                            $students[] = [
                                'name' => $studentName,
                                'subject' => $subject,
                                'grade' => $grade,
                                'attendance' => $attendance
                            ];
                            $_SESSION['students'] = $students;
                        }

                        $students = isset($_SESSION['students']) ? $_SESSION['students'] : [];
                        if (count($students) > 0) {
                            foreach ($students as $key => $student) {
                                echo "<tr>
                                    <td>" . ($key + 1) . "</td>
                                    <td>{$student['name']}</td>
                                    <td>{$student['subject']}</td>
                                    <td>{$student['grade']}</td>
                                    <td>{$student['attendance']}</td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No student data uploaded yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="material" class="hidden">
                <fieldset>
                    <legend>Upload Learning Material</legend>
                    <form class="material-upload-form" method="POST" enctype="multipart/form-data">
                        <div>
                            <label for="material-title">Title:</label>
                            <input type="text" id="material-title" name="material-title" placeholder="Enter material title" required>
                        </div>

                        <div>
                            <label for="material-file">Upload File (Image/PDF):</label>
                            <input type="file" id="material-file" name="material-file" accept="image/*,application/pdf" required>
                        </div>

                        <div>
                            <label for="education">School Level:</label>
                            <select id="material-education" name="material-education" required>
                                <option value="" disabled selected>Select School Level</option>
                                <option value="sjkc">SJKC</option>
                                <option value="sk">SK</option>
                                <option value="secondary">Secondary</option>
                            </select>
                        </div>

                        <div>
                            <label for="subject">Subject:</label>
                            <select id="material-subject" name="material-subject" required>
                                <option value="" disabled selected>Select Subject</option>
                                <option value="math">Mathematics</option>
                                <option value="science">Science</option>
                                <option value="english">English</option>
                                <option value="history">History</option>
                            </select>
                        </div>

                        <button type="submit" name="uploadLearningMaterial">Upload</button>
                        <button type="reset">Clear</button>
                    </form>
                </fieldset>

                <h3>Uploaded Learning Materials</h3>
                <table id="materials-table" class="materials-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>School Level</th>
                            <th>Subject</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['uploadLearningMaterial'])) {
                            $materialTitle = $_POST['material-title'];
                            $materialEducation = $_POST['material-education'];
                            $materialSubject = $_POST['material-subject'];
                            $materialFile = $_FILES['material-file'];

                            // Store in database or session
                            $materials = isset($_SESSION['materials']) ? $_SESSION['materials'] : [];
                            $materials[] = [
                                'title' => $materialTitle,
                                'school_level' => $materialEducation,
                                'subject' => $materialSubject,
                                'file_name' => $materialFile['name']
                            ];
                            $_SESSION['materials'] = $materials;
                        }

                        $materials = isset($_SESSION['materials']) ? $_SESSION['materials'] : [];
                        if (count($materials) > 0) {
                            foreach ($materials as $key => $material) {
                                echo "<tr>
                                    <td>" . ($key + 1) . "</td>
                                    <td>{$material['title']}</td>
                                    <td>{$material['school_level']}</td>
                                    <td>{$material['subject']}</td>
                                    <td><a href='uploads/{$material['file_name']}' target='_blank'>View File</a></td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No materials uploaded yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="Teacher.js" defer></script>
</body>
</html>
