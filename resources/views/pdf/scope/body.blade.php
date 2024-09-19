<?php
$firstNames = ['John', 'Jane', 'Michael', 'Emily', 'David', 'Sarah', 'Chris', 'Jessica', 'Daniel', 'Laura'];
$lastNames = ['Smith', 'Johnson', 'Brown', 'Williams', 'Jones', 'Garcia', 'Miller', 'Davis', 'Martinez', 'Hernandez'];

// Lorem Ipsum text to be used for generating random description
$loremIpsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

// Function to generate a random description between 20 and 200 words
function getRandomDescription($loremIpsum) {
    $words = explode(' ', $loremIpsum);
    $numWords = rand(5, 200); // Random number of words between 20 and 200
    $randomWords = array_slice($words, 0, $numWords);
    return implode(' ', $randomWords);
}
?>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Name</th>
            <th>Lastname</th>
            <th>Description</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < 100; $i++)
            <tr>
                <td style="width:20%">{{ $firstNames[array_rand($firstNames)] }}</td> <!-- สุ่มชื่อ -->
                <td style="width:20%">{{ $lastNames[array_rand($lastNames)] }}</td> <!-- สุ่มนามสกุล -->
                <td style="width:50%">{{ getRandomDescription($loremIpsum) }}</td> <!-- สุ่มคำอธิบาย 20 - 200 คำ -->
                <td style="width:10%">{{ rand(50, 100) }}</td> <!-- สุ่มคะแนนระหว่าง 50 ถึง 100 -->
            </tr>
        @endfor
    </tbody>
</table>
