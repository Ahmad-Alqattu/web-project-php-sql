<?php
session_start();
include "conectdb.php";
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $identity_number = $_POST['identity_number'];
    $nationality = $_POST['nationality'];
    $address = $_POST['address'];
    $mobile_number = $_POST['mobile_number'];
    $email = $_POST['email'];
    $qualification = $_POST['qualification'];
    $experience = $_POST['experience'];


    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        // Get the file data
        $file_tmp = $_FILES['cv']['tmp_name'];
        $cv = $_FILES['cv']['name'];


        // Create a unique file name
        $file_path = ".\uploads\c" . uniqid() . $cv;
        $cv_path = $file_path;
        if (is_uploaded_file($file_tmp)) {
            //in case you want to move  the file in uploads directory
            move_uploaded_file($file_tmp, $file_path);
        }

    }
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        // Get the file data
        $file_tmp = $_FILES['photo']['tmp_name'];
        $photo = $_FILES['photo']['name'];

        // Create a unique file name
        $file_path = ".\uploads\p" . uniqid() . $photo;
        $ph_path = $file_path;

        if (is_uploaded_file($file_tmp)) {
            //in case you want to move  the file in uploads directory
            move_uploaded_file($file_tmp, $file_path);
        }
    }
    // $unique_id = substr(sha1(uniqid(rand(), true)), 0, 6);

    $unique_id = rand(100000, 999999);
    $_SESSION["mem_id"] = $unique_id;
    $query = "INSERT INTO `members` (id ,name, identity_number, nationality,address, mobile_number, email, photo, qualification, experience, cv)
              VALUES ( :unique_id, :name, :identity_number,:nationality,:address,:mobile_number, :email, :photo, :qualification, :experience, :cv)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':unique_id', $unique_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':identity_number', $identity_number);
    $stmt->bindParam(':nationality', $nationality);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':mobile_number', $mobile_number);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':photo', $ph_path);
    $stmt->bindParam(':qualification', $qualification);
    $stmt->bindParam(':experience', $experience);
    $stmt->bindParam(':cv', $cv_path);
    echo $query;
    $stmt->execute();
    header("location:creatAccount.php");
    exit();
}

// Connect to the database

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/regester.css" />
    <title>Ahmad AL-Qattu</title>
</head>

<body>
    <?php include 'header.php' ?>

    <?php
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        // Get the file data
        $file_tmp = $_FILES['cv']['tmp_name'];
        $file_name = $_FILES['cv']['name'];
    }
    ?>
    <section class="Member-reg">
        <h1>Member Registration</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Your Detail</legend>
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" placeholder="Name:" name="name" required>
                </div>
                <div>
                    <label for="identity_number">Identity Number:</label>
                    <input type="text" placeholder="Identity Number:" id="identity_number" name="identity_number"
                        required>
                    <br>
                </div>

                <div>
                    <label for="address">Address:</label>

                    <input type="text" id="address" name="address" placeholder="Address:" required>
                </div>
                <div>
                    <label for="mobile_number">Mobile Number:</label>

                    <input type="text" id="mobile_number" name="mobile_number" placeholder="Mobile Number:" required>
                    <br>
                </div>
                <div>
                    <label for="email">Email:</label>

                    <input type="email" id="email" name="email" placeholder="Email:" required>
                    <br>
                </div>
                <div>
                    <label for="qualification">Qualification:</label>

                    <input type="text" id="qualification" name="qualification" placeholder="Qualification:" required>
                    <br>
                </div>
                <div>
                    <label for="experience">Working Experience:</label>

                    <input type="text" id="experience" name="experience" placeholder="Working Experience:" required>
                    <br>
                </div>
                <div>
                    <label for="nationality">Nationality:</label>
                    <?php
                    $nationalities = array("Afghan", "Albanian", "Algerian", "American", "Andorran", "Angolan", "Antiguans", "Argentinean", "Armenian", "Australian", "Austrian", "Azerbaijani", "Bahamian", "Bahraini", "Bangladeshi", "Barbadian", "Barbudans", "Batswana", "Belarusian", "Belgian", "Belizean", "Beninese", "Bhutanese", "Bolivian", "Bosnian", "Brazilian", "British", "Bruneian", "Bulgarian", "Burkinabe", "Burmese", "Burundian", "Cambodian", "Cameroonian", "Canadian", "Cape Verdean", "Central African", "Chadian", "Chilean", "Chinese", "Colombian", "Comoran", "Congolese", "Costa Rican", "Croatian", "Cuban", "Cypriot", "Czech", "Danish", "Djibouti", "Dominican", "Dutch", "East Timorese", "Ecuadorean", "Egyptian", "Emirian", "Equatorial Guinean", "Eritrean", "Estonian", "Ethiopian", "Fijian", "Filipino", "Finnish", "French", "Gabonese", "Gambian", "Georgian", "German", "Ghanaian", "Greek", "Grenadian", "Guatemalan", "Guinea-Bissauan", "Guinean", "Guyanese", "Haitian", "Herzegovinian", "Honduran", "Hungarian", "I-Kiribati", "Icelander", "Indian", "Indonesian", "Iranian", "Iraqi", "Irish", "Israeli", "Italian", "Ivorian", "Jamaican", "Japanese", "Jordanian", "Kazakhstani", "Kenyan", "Kittian and Nevisian", "Kuwaiti", "Kyrgyz", "Laotian", "Latvian", "Lebanese", "Liberian", "Libyan", "Liechtensteiner", "Lithuanian", "Luxembourger", "Macedonian", "Malagasy", "Malawian", "Malaysian", "Maldivan", "Malian", "Maltese", "Marshallese", "Mauritanian", "Mauritian", "Mexican", "Micronesian", "Moldovan", "Monacan", "Mongolian", "Moroccan", "Mosotho", "Motswana", "Mozambican", "Namibian", "Nauruan", "Nepalese", "New Zealander", "Nicaraguan", "Nigerian", "Nigerien", "North Korean", "Norwegian", "Omani", "Pakistani", "Panamanian", "Papua New Guinean", "Paraguayan", "Peruvian", "Polish", "Portuguese", "Qatari", "Romanian", "Russian", "Rwandan", "Saint Lucian", "Salvadoran", "Samoan");
                    ?>
                    <select id="nationality" name="nationality">
                        <?php foreach ($nationalities as $nationality) { ?>
                        <option value="<?php echo $nationality; ?>"><?php echo $nationality; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="cv">CV:</label>

                    <input type="file" id="cv" name="cv" placeholder="CV:" required>
                    <br>
                </div>
                <div>
                    <label for="photo">Photo:</label>

                    <input type="file" id="photo" name="photo" placeholder="Photo:" required>
                </div>
                <div>
                    <div>
                        <input type="submit" name="submit" value="Submit">
                        <p>I have Account<a href="index.php"> Login</a></p>

                    </div>
                </div>

            </fieldset>

        </form>
    </section>


    <?php include 'footer.php' ?>

</body>

</html>