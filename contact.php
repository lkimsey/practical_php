<?php 
    define("TITLE", "Contact Us | Franklin's Fine Dining");

    include('include/header.php');
?>

    <div id="contact">

        <hr>
        <h1>Get in touch with us!</h1>

        <?php 

            // Check For Header Injection
            function has_header_injection($str) {
                return preg_match("/[\r\n]/", $str);
            }

            if (isset ($_POST['contact_submit'])) {
                $name = trim($_POST['name']);
                $email = trim($_POST['email']);
                $msg = $_POST['message'];

                // Check to see if $name or $email have header injections
                if (has_header_injection($name) || has_header_injection($email)) {
                    die();
                }

                if (!$name || !$email || !$msg ) {
                    echo "<h4 class='error'>All Fields Required</h4><a href='contact.php' class='button-block'>Go Back and Try Again</a>";
                    exit;
                }

                // Construct Email Message
                // Add the recipient email to a variable
                $to = "sorenbaird@gmail.com";

                // Create a Subject
                $subject = "$name sent you a message via your contact form";

                //Construct the message
                $message = "Name: $name\r\n";
                $message .= "Email: $email\r\n";
                $message .= "Message:\r\n$msg";

                // If the Subscribe Checkbox was checked...
                if (isset($_POST['subscribe']) && $_POST['subscribe'] == 'Subscribe') {
                    // Add a new line to the $message
                    $message .= "\r\n\r\nPlease add $email to the mailing list.\r\n";
                }

                $message = wordwrap($message, 72);

                // Set the mail headers into a variable
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
                $headers .= "From: $name <$email> \r\n";
                $headers .= "X-Priority: 1\r\n";
                $headers .= "X-MSMail-Priority: High\r\n\r\n";

                // Send the email!
                mail( $to, $subject, $message, $headers );
        ?>

        <!-- Show success message after email has sent -->
        <h5>Thank you for contacting Franklin's!</h5>
        <p>Please allow 24 hours for a response.</p>
        <p><a href="index.php" class="button block">&laquo; Go to Home Page</a></p>

        <?php } else { ?>

        <form method="post" action="" id="contact-form">

            <label for="name">Your Name</label>
            <input type="text" id="name" name="name">

            <label for="email">Your Email</label>
            <input type="email" id="email" name="email">

            <label for="message">Your Message</label>
            <textarea id="message" name="message"></textarea>

            <input type="checkbox" id="subscribe" name="subscribe" value="Subscribe">
            <label for="subscribe">Subscribe to newsletter</label>

            <input type="submit" class="button next" name="contact_submit" value="Send Message">

        </form>

        <?php } ?>
        <hr>
    </div><!-- contact -->

<?php include('include/footer.php'); ?>