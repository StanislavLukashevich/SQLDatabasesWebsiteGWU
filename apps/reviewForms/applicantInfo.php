<h3 align="center">Applicant Information</h3> 
<table>
	 <tr>
		<th>Semester and Year of Application: </th>
		<td><?php if(strcmp($term, "2020-08") == 0){
				echo "Fall 2020"; 
			}else{
				echo"Spring 2021";
			}?></td>
	</tr>
	<tr>
		<th>Degree: </th>
		<td><?php echo $degree; ?></td>
	</tr>
	<tr>
		<th>Areas of Interest: </th>
		<td><?php echo $interest; ?> </td>
	</tr>
</table><br/>


<h2 align="center">Experience</h2>
<table>
	<tr>
		<th>Employer</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Position</th>
	</tr>
	<tr>
		<?php
			while($applicantExp = mysqli_fetch_array($expResult)){
				$employer = $applicantExp['employer'];
				$startDate = $applicantExp['startDate'];
				$endDate = $applicantExp['endDate'];
				$position = $applicantExp['position'];
				$description = $applicantExp['description'];

				echo "<td>$employer</td>
					<td>$startDate</td>
					<td>$endDate</td>
					<td>$position</td>
				</tr>
				<tr>
					<th>Description</th>
					<td>$description</td>
				</tr>";
			}
		?>
</table>


<?php
	// echo"<button class='btn btn-primary' id='next' onclick='nextPage($applicationID)'>Next</button>";
?>