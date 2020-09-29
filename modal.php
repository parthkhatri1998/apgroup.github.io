<!--POP UP MODAL CONTACT FORM SECTION-->

<!--<section id="pop-up-modal" class="contact">-->
<div id="pop-up-modal" class="contact">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                    <div class="form-row">
                        <div class="col form-group">
                            <input type="text" name="customer_name" class="form-control" id="name" placeholder="Your Name"
                                   data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                            <div class="validate"></div>
                        </div>
                        <div class="col form-group">
                            <input type="email" class="form-control" name="customer_email" id="email" placeholder="Your Email"
                                   data-rule="email" data-msg="Please enter a valid email" />
                            <div class="validate"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control" name="customer_number" id="number" placeholder="Mobile Number"
                               data-rule="required" data-msg="Please enter your mobile number" />
                        <div class="validate"></div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="customer_subject" id="subject" placeholder="Subject"
                               data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                        <div class="validate"></div>
                    </div>
                    <div class="form-group">
                <textarea class="form-control" name="customer_msg" rows="5" data-rule="required"
                          data-msg="Please write something for us" placeholder="Message"></textarea>
                        <div class="validate"></div>
                    </div>
                    <div class="mb-3">
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your message has been sent. Thank you!</div>
                    </div>
                    <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--</section>-->

<!--  JAVA SCRIPT FOR MODAL FORM VALIDATION-->

<script src="assets/vendor/php-email-form/validate.js"></script>
<script>
    setTimeout(function(){
        $("#myModal").modal('show');
    },4000);
</script>

<!--END OF POP UP MODAL-->