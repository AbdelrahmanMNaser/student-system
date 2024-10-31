<?php

function calculate_total_score($student_id, $course_id, $semester_id) {
    global $conn;

    $sql = "SELECT 
        assessment_score.student_id, 
        assessment.course_id, 
        assessment.semester_id, 
        SUM(assessment_score.score) AS total_score
        
    FROM 
        assessment, assessment_score, enrollment, course
    WHERE 
        assessment_score.student_id = $student_id 
        AND assessment.course_id = $course_id 
        AND assessment.semester_id =  $semester_id  
        AND assessment.assess_id = assessment_score.assessment_id 
        AND assessment_score.student_id = enrollment.student_id 
        AND assessment.course_id = enrollment.course_id 
        AND assessment.semester_id = enrollment.semester_id 
        AND enrollment.course_id = course.id
    GROUP BY 
        assessment_score.student_id, 
        assessment.course_id, 
        assessment.semester_id
    
    HAVING
        SUM(assessment.max_score) = 100
    ";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_score'];
    }
}


// The following scoring system is for Faculty of Science
function calculate_grade($score) {
    if ($score != null) {
        if ($score >= 90) {
            return 'A';
        } elseif ($score >= 85) {
            return 'A-';
        } elseif ($score >= 80) {
            return 'B+';
        } elseif ($score >= 75) {
            return 'B';
        } elseif ($score >= 70) {
            return 'B-';
        } elseif ($score >= 65) {
            return 'C+';
        } elseif ($score >= 60) {
            return 'C-';
        } elseif ($score >= 56) {
            return 'C';
        } elseif ($score >= 53) {
            return 'D+';
        } elseif ($score >= 50) {
            return 'D';
        } else {
            return 'F';
        }
    }

}

function calculate_total_credits($student_id) {
  global $conn;
  
  //get the courses where total score is greater than 50
  $sql = "SELECT 
  assessment_score.student_id, 
  assessment.course_id, 
  assessment.semester_id, 
  SUM(assessment_score.score) AS total_score,
  course.credit AS course_credit
  
  FROM 
      assessment, assessment_score, enrollment, course
  WHERE 
      assessment_score.student_id = $student_id
      AND assessment.assess_id = assessment_score.assessment_id 
      AND assessment_score.student_id = enrollment.student_id 
      AND assessment.course_id = enrollment.course_id 
      AND assessment.semester_id = enrollment.semester_id  
      AND enrollment.course_id = course.id
  GROUP BY 
      assessment_score.student_id, 
      assessment.course_id, 
      assessment.semester_id
  HAVING 
      total_score > 50
";

  // Execute query
  $result = $conn->query($sql);

  // Initialize total credits
  $total_credits = 0;

  // Fetch data and calculate total credits
  while ($row = $result->fetch_assoc()) {
      $total_credits += $row['course_credit'];
  }

  return $total_credits;

}

// Calculate level based on total credits
// Faculty of Science leveling system
function calculate_student_level($total_credits) {

    if ($total_credits < 33) {
        return 1;
    } elseif ($total_credits <= 66) {
        return 2;
    } elseif ($total_credits <= 99) {
        return 3;
    } else {
        return 4;
    }
}


?>