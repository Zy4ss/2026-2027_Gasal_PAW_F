<?php
$surname = isset($_POST['surname']) ? htmlspecialchars($_POST['surname'], ENT_QUOTES, 'UTF-8') : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : '';
$address = isset($_POST['address']) ? htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8') : '';
$state = isset($_POST['state']) ? $_POST['state'] : '-1';
$sex = isset($_POST['sex']) ? $_POST['sex'] : '';
$vegetarian = isset($_POST['vegetarian']);
?>

<form action="processData_form.php" method="POST">
    <fieldset>
        <legend>Person Details</legend>

        <div class="field">
            <label for="surname">Surname</label>
            <input type="text" name="surname" id="surname" size="31" value="<?php echo $surname; ?>">
            <?php if (isset($errors['surname'])) echo '<span class="error">' . htmlspecialchars($errors['surname'], ENT_QUOTES, 'UTF-8') . '</span>'; ?>
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input type="text" name="email" id="email" size="31" value="<?php echo $email; ?>">
            <?php if (isset($errors['email'])) echo '<span class="error">' . htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') . '</span>'; ?>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" size="31">
            <?php if (isset($errors['password'])) echo '<span class="error">' . htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') . '</span>'; ?>
        </div>

        <div class="field">
            <label for="address">Street Address</label>
            <textarea name="address" id="address" rows="3" cols="22"><?php echo $address; ?></textarea>
            <?php if (isset($errors['address'])) echo '<span class="error">' . htmlspecialchars($errors['address'], ENT_QUOTES, 'UTF-8') . '</span>'; ?>
        </div>

        <div class="field">
            <label for="state">State</label>
            <select name="state" id="state">
                <option value="-1" <?php if ($state === '-1') echo 'selected'; ?>>Choose your state</option>
                <option value="1" <?php if ($state === '1') echo 'selected'; ?>>Australian Capital Territory</option>
                <option value="2" <?php if ($state === '2') echo 'selected'; ?>>Queensland</option>
                <option value="3" <?php if ($state === '3') echo 'selected'; ?>>Victoria</option>
                <option value="4" <?php if ($state === '4') echo 'selected'; ?>>New South Wales</option>
                <option value="5" <?php if ($state === '5') echo 'selected'; ?>>Tasmania</option>
                <option value="6" <?php if ($state === '6') echo 'selected'; ?>>South Australia</option>
                <option value="7" <?php if ($state === '7') echo 'selected'; ?>>Western Australia</option>
                <option value="8" <?php if ($state === '8') echo 'selected'; ?>>Northern Territory</option>
            </select>
            <?php if (isset($errors['state'])) echo '<span class="error">' . htmlspecialchars($errors['state'], ENT_QUOTES, 'UTF-8') . '</span>'; ?>
        </div>

        <div class="field">
            <input type="hidden" name="country" value="Australia">
        </div>

        <div class="field">
            <label>Gender</label>
            <input type="radio" name="sex" value="Male" <?php if ($sex === 'Male') echo 'checked'; ?>>Male
            <input type="radio" name="sex" value="Female" <?php if ($sex === 'Female') echo 'checked'; ?>>Female
            <?php if (isset($errors['sex'])) echo '<span class="error">' . htmlspecialchars($errors['sex'], ENT_QUOTES, 'UTF-8') . '</span>'; ?>
        </div>

        <div class="field">
            <label for="vegetarian">Vegetarian?</label>
            <input type="checkbox" name="vegetarian" id="vegetarian" value="Yes" <?php if ($vegetarian) echo 'checked'; ?>>
        </div>

        <div class="field">
            <label>&nbsp;</label>
            <input type="submit" value="Submit" name="submit">
            <input type="reset" value="Reset" name="reset">
        </div>
    </fieldset>
</form>
