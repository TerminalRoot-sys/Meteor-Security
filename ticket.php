<?php
    require_once("@/sys/area.php");
    if(!empty($_GET["id"])){
        if(empty(GetTickets($_GET["id"]))){ header("Location: support.php"); die(); }
        else{
            $ticket= GetTickets($_GET["id"]);
        }
    }
?>
<!doctype html>
<html lang="en" class="no-focus">
    <?php include("@/inc/head.php"); ?>
    <body>
        <div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-fixed page-header-fixed page-header-glass main-content-boxed bg-primary-darker text-body-color-light">
            <?php
                include("@/inc/nav.php");
                include("@/inc/header.php");
            ?>
            <main id="main-container">
                <?php
                    if(!empty($_GET["id"])){
                ?>
                <div class="content">
                    <a class="btn btn-primary btn-rounded mb-1" data-toggle="collapse" href="#reply" aria-expanded="true" aria-controls="reply"><i class="fa fa-plus"></i> New reply</a>
                    <div class="block bg-dark border-0">
                        <div class="block-header block-header-default bg-mn-dark border-0 border-b">
                            <h3 class="block-title text-white"><?php echo ChatMessage($ticket["subject"]); ?></h3>
                            <div class="block-options">
                                <a class="btn-block-option" data-toggle="collapse" href="#reply" aria-expanded="true" aria-controls="reply">
                                    <i class="fa fa-reply"></i> Reply
                                </a>
                            </div>
                        </div>
                        <div id="reply" class="collapse" role="tabpanel" aria-labelledby="reply" data-parent="#reply">
                            <div class="block-content bg-mn-dark border-b">
                                <h3 class="text-center text-white">Your reply</h3>
                                <div class="form-group text-center">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-7">
                                            <div id="response"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <div class="row justify-content-center">
                                        <div class="col-7">
                                            <div class="MyWYSIWYG">
                                                <div class="WYSIWYGcontainer">
                                                    <div class="btngroup row">
                                                        <button class="btn btn-sm btn-default col" onclick="MyWYSIWYG_Process('*', 'message');"><strong>Bolt text</strong></button>
                                                        <button class="btn btn-sm btn-default col" onclick="MyWYSIWYG_Process('__', 'message');"><u>Underline text</u></button>
                                                        <button class="btn btn-sm btn-default col" onclick="MyWYSIWYG_Process('--', 'message');"><del>Deleted text</del></button>
                                                        <button class="btn btn-sm btn-default col" onclick="MyWYSIWYG_Process('`', 'message');"><small>Small text</small></button>
                                                        <div class="dropdown col p-0">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Colored text</button>
                                                            <div class="dropdown-menu" style="background-color: #808080;" aria-labelledby="dropdownMenuButton">
                                                                <button class="dropdown-item text-danger" onclick="MyWYSIWYG_Process('~d~', 'message');">Color danger</button>
                                                                <button class="dropdown-item text-warning" onclick="MyWYSIWYG_Process('~w~', 'message');">Color warning</button>
                                                                <button class="dropdown-item text-success" onclick="MyWYSIWYG_Process('~s~', 'message');">Color success</button>
                                                                <button class="dropdown-item text-primary" onclick="MyWYSIWYG_Process('~p~', 'message');">Color primary</button>
                                                                <button class="dropdown-item text-info" onclick="MyWYSIWYG_Process('~i~', 'message');">Color info</button>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown col p-0">
                                                            <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-smile"></i></button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <li class="dropdown-item">
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':smile:', 'message');"><i class="fa fa-smile"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':smile_beam:', 'message');"><i class="fa fa-smile-beam"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':smile_wink:', 'message');"><i class="fa fa-smile-wink"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin:', 'message');"><i class="fa fa-grin"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_alt:', 'message');"><i class="fa fa-grin-alt"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_beam:', 'message');"><i class="fa fa-grin-beam"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_beam_sweat:', 'message');"><i class="fa fa-grin-beam-sweat"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_hearts:', 'message');"><i class="fa fa-grin-hearts"></i></button>
                                                                </li>
                                                                <li class="dropdown-item">
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_squint:', 'message');"><i class="fa fa-grin-squint"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_stars:', 'message');"><i class="fa fa-grin-stars"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_squint_tears:', 'message');"><i class="fa fa-grin-squint-tears"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_tears:', 'message');"><i class="fa fa-grin-tears"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_tongue:', 'message');"><i class="fa fa-grin-tongue"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_tongue_squint:', 'message');"><i class="fa fa-grin-tongue-squint"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_tongue_wink:', 'message');"><i class="fa fa-grin-tongue-wink"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':laugh:', 'message');"><i class="fa fa-laugh"></i></button>
                                                                </li>
                                                                <li class="dropdown-item">
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':laugh_beam:', 'message');"><i class="fa fa-laugh-beam"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':laugh_squint:', 'message');"><i class="fa fa-laugh-squint"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':laugh_wink:', 'message');"><i class="fa fa-laugh-wink"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':kiss:', 'message');"><i class="fa fa-kiss"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':kiss_beam:', 'message');"><i class="fa fa-kiss-beam"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':kiss_wink_heart:', 'message');"><i class="fa fa-kiss-wink-heart"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':frown:', 'message');"><i class="fa fa-frown"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':angry:', 'message');"><i class="fa fa-angry"></i></button>
                                                                </li>
                                                                <li class="dropdown-item">
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':surprise:', 'message');"><i class="fa fa-surprise"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':hand_peace:', 'message');"><i class="fa fa-hand-peace"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':thumbs_up:', 'message');"><i class="fa fa-thumbs-up"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':thumbs_down:', 'message');"><i class="fa fa-thumbs-down"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':gem:', 'message');"><i class="fa fa-gem text-primary"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':star:', 'message');"><i class="fa fa-star text-warning"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':heart:', 'message');"><i class="fa fa-heart text-danger"></i></button>
                                                                    <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':box:', 'message');"><i class="fa fa-box text-warning"></i></button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <textarea class="form-control form-control-lg" id="message" rows="4" placeholder="Enter your message.." disabled></textarea>
                                                <small class="text-white">* Our entire website is protected against XSS fails, any attempt will be a waste of time.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="col-4 bg-dark pb-5 text-center">
                                            <div id="captchaImage" class="text-center">
                                                <h5 class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i><br>Loading</h5>
                                            </div>
                                            <input type="text" class="form-control bg-primary-darker text-white border-0 text-center" id="captchaCode" placeholder="Enter the image code" name="captcha" required>
                                            <small>Enter the exact letters on the image</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" id="doReply" onclick="ReplyToTicket()" class="btn btn-alt-primary">
                                        <i class="fa fa-reply"></i> Reply
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content">
                            <table class="table table-borderless">
                                <tbody>
                                    <?php
                                        $replies = array_reverse(GetTicketReplies($ticket["id"]));
                                        foreach($replies as $reply){
                                            if($reply["type"] == 1 && $reply["rid"] == $userinfo["id"]){
                                                echo '
                                                <tr class="border-b">
                                                    <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                                        <div class="mb-10">
                                                            <a href="profile.php">
                                                                <img class="img-avatar" src="assets/media/avatars/avatar15.png" alt="">
                                                            </a>
                                                        </div>
                                                        <small>By You</small>
                                                    </td>
                                                    <td>
                                                        <p>'.ChatMessage($reply["message"], TRUE).'</p>
                                                        <br>
                                                        <p class="font-size-sm text-muted">Posted on '.date("F d, Y h:ia", $reply["date"]).' by <b>You</b></p>
                                                    </td>
                                                </tr>
                                                ';
                                            }elseif($reply["type"] == 2){
                                                echo '
                                                <tr class="border-b">
                                                    <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                                        <div class="mb-10">
                                                            <img class="img-avatar" src="assets/media/avatars/avatar15'.($reply["rid"] == 0 ? '-s' : '-a').'.png" alt="">
                                                        </div>
                                                        <small>By '.($reply["rid"] == 0 ? 'System' : 'Support').'</small>
                                                    </td>
                                                    <td>
                                                        <p>'.ChatMessage($reply["message"], TRUE).'</p>
                                                        <br>
                                                        <p class="font-size-sm text-muted">Posted on '.date("F d, Y h:ia", $ticket["date"]).' by <b>'.($reply["rid"] == 0 ? 'System' : 'Support').'</b></p>
                                                    </td>
                                                </tr>
                                                ';
                                            }elseif($reply["type"] == 3){
                                                echo '<tr class="table-active">
                                                            <td class="font-size-sm text-muted text-center" colspan="2">
                                                                '.ChatMessage($reply["message"], TRUE).'
                                                            </td>
                                                        </tr>';
                                            }
                                        }
                                    ?>
                                    <tr class="border-b">
                                        <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                            <div class="mb-10">
                                                <a href="be_pages_generic_profile.html">
                                                    <img class="img-avatar" src="assets/media/avatars/avatar15-s.png" alt="">
                                                </a>
                                            </div>
                                            <small>By System</small>
                                        </td>
                                        <td>
                                            <p>Hi <b><?php echo $userinfo["username"] ?></b> !<br/>Our team assigned to <b><?php echo GetTicketCategories($ticket["categorie"])["name"]; ?> tickets</b> will answer to your ticket. Please be patient, your ticket will be treated ticket ASAP !<br/>Estimated time is under 24 hours.<br/> <b>Warning: </b>Each reply you will send will impact your wait time.<br/><b>Example:</b> If you give a reply 3 hours before receiving any response from our support, the tickets opened after your ticket can be treated before your. </p>
                                            <br>
                                            <p class="font-size-sm text-muted">Posted on <?php echo date("F d, Y h:ia"); ?> by <b>System</b></p>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                            <div class="mb-10">
                                                <a href="profile.php">
                                                    <img class="img-avatar" src="assets/media/avatars/avatar15.png" alt="">
                                                </a>
                                            </div>
                                            <small>By You</small>
                                        </td>
                                        <td>
                                            <p><?php echo ChatMessage($ticket["reason"]); ?></p>
                                            <br>
                                            <p class="font-size-sm text-muted">Posted on <?php echo date("F d, Y h:ia"); ?> by <b>You</b></p>
                                        </td>
                                    </tr>
                                    <tr class="table-active">
                                        <td class="font-size-sm text-muted text-center" colspan="2">
                                            Ticket <b>#<?php echo $ticket["publicid"]; ?></b> opened on <em><?php echo date("F d Y h:ia", $ticket["date"]); ?></em>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                    }else{
                ?>
                <div class="bg-primary">
                    <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                        <div class="content content-top text-center">
                            <div class="py-10">
                                <h1 class="font-w700 text-white mb-10">Get In Touch</h1>
                                <h2 class="h4 font-w400 text-white-op">Do you have any questions?</h2>
                                <h3 class="h5 font-w400 text-white-op">Email us: contact@takedown.pw or open support ticket</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content content-full">
                    <div class="row justify-content-center py-30">
                        <div class="col-lg-8 col-xl-6">
                            <div class="js-validation-be-contact">
                                <div id="response"></div>
                                <div class="form-group row">
                                    <label class="col-6" for="be-contact-email">Email</label>
                                    <label class="col-6" for="be-contact-email">Username</label>
                                    <div class="col-6">
                                        <input type="email" class="form-control form-control-lg" id="email" placeholder="Enter your email.." value="<?php echo $userinfo["email"]; ?>" disabled>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-lg" id="username" placeholder="Enter your username.." value="<?php echo $userinfo["username"]; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label for="be-contact-name">Subject</label>
                                        <input type="text" class="form-control form-control-lg" id="subject" placeholder="Enter the subject of your ticket.." disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="be-contact-subject">Categorie</label>
                                    <div class="col-12">
                                        <select class="form-control form-control-lg" id="categorie" disabled>
                                            <?php
                                                $categories = GetTicketCategories();
                                                foreach($categories as $categorie){
                                                    echo '<option value="'.$categorie["id"].'">'.$categorie["name"].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12" for="be-contact-message">Message</label>
                                    <div class="col-sm-12">
                                        <div class="MyWYSIWYG">
                                            <div class="WYSIWYGcontainer">
                                                <div class="btngroup row">
                                                    <button class="btn btn-sm btn-default col" onclick="MyWYSIWYG_Process('*', 'message');"><strong>Bolt text</strong></button>
                                                    <button class="btn btn-sm btn-default col" onclick="MyWYSIWYG_Process('__', 'message');"><u>Underline text</u></button>
                                                    <button class="btn btn-sm btn-default col" onclick="MyWYSIWYG_Process('--', 'message');"><del>Deleted text</del></button>
                                                    <button class="btn btn-sm btn-default col" onclick="MyWYSIWYG_Process('`', 'message');"><small>Small text</small></button>
                                                    <div class="dropdown col p-0">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Colored text</button>
                                                        <div class="dropdown-menu" style="background-color: #808080;" aria-labelledby="dropdownMenuButton">
                                                            <button class="dropdown-item text-danger" onclick="MyWYSIWYG_Process('~d~', 'message');">Color danger</button>
                                                            <button class="dropdown-item text-warning" onclick="MyWYSIWYG_Process('~w~', 'message');">Color warning</button>
                                                            <button class="dropdown-item text-success" onclick="MyWYSIWYG_Process('~s~', 'message');">Color success</button>
                                                            <button class="dropdown-item text-primary" onclick="MyWYSIWYG_Process('~p~', 'message');">Color primary</button>
                                                            <button class="dropdown-item text-info" onclick="MyWYSIWYG_Process('~i~', 'message');">Color info</button>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown col p-0">
                                                        <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-smile"></i></button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <li class="dropdown-item">
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':smile:', 'message');"><i class="fa fa-smile"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':smile_beam:', 'message');"><i class="fa fa-smile-beam"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':smile_wink:', 'message');"><i class="fa fa-smile-wink"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin:', 'message');"><i class="fa fa-grin"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_alt:', 'message');"><i class="fa fa-grin-alt"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_beam:', 'message');"><i class="fa fa-grin-beam"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_beam_sweat:', 'message');"><i class="fa fa-grin-beam-sweat"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_hearts:', 'message');"><i class="fa fa-grin-hearts"></i></button>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_squint:', 'message');"><i class="fa fa-grin-squint"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_stars:', 'message');"><i class="fa fa-grin-stars"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_squint_tears:', 'message');"><i class="fa fa-grin-squint-tears"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_tears:', 'message');"><i class="fa fa-grin-tears"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_tongue:', 'message');"><i class="fa fa-grin-tongue"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_tongue_squint:', 'message');"><i class="fa fa-grin-tongue-squint"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':grin_tongue_wink:', 'message');"><i class="fa fa-grin-tongue-wink"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':laugh:', 'message');"><i class="fa fa-laugh"></i></button>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':laugh_beam:', 'message');"><i class="fa fa-laugh-beam"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':laugh_squint:', 'message');"><i class="fa fa-laugh-squint"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':laugh_wink:', 'message');"><i class="fa fa-laugh-wink"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':kiss:', 'message');"><i class="fa fa-kiss"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':kiss_beam:', 'message');"><i class="fa fa-kiss-beam"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':kiss_wink_heart:', 'message');"><i class="fa fa-kiss-wink-heart"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':frown:', 'message');"><i class="fa fa-frown"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':angry:', 'message');"><i class="fa fa-angry"></i></button>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':surprise:', 'message');"><i class="fa fa-surprise"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':hand_peace:', 'message');"><i class="fa fa-hand-peace"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':thumbs_up:', 'message');"><i class="fa fa-thumbs-up"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':thumbs_down:', 'message');"><i class="fa fa-thumbs-down"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':gem:', 'message');"><i class="fa fa-gem text-primary"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':star:', 'message');"><i class="fa fa-star text-warning"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':heart:', 'message');"><i class="fa fa-heart text-danger"></i></button>
                                                                <button class="btn btn-default" onclick="MyWYSIWYG_Insert(':box:', 'message');"><i class="fa fa-box text-warning"></i></button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <textarea class="form-control form-control-lg" id="message" rows="4" placeholder="Enter your message.." disabled></textarea>
                                            <small class="text-white">* Our entire website is protected against XSS fails, any attempt will be a waste of time.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="col-6 bg-dark pb-5 text-center">
                                            <div id="captchaImage" class="text-center">
                                                <h5 class="text-center text-muted"><i class="fa fa-spinner fa-spin"></i><br>Loading</h5>
                                            </div>
                                            <input type="text" class="form-control bg-primary-darker text-white border-0 text-center" id="captchaCode" placeholder="Enter the image code" name="captcha" required>
                                            <small>Enter the exact letters on the image</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 text-center">
                                        <button id="doTicket" class="btn btn-hero btn-alt-primary min-width-175" onclick="OpenTicket()" disabled>
                                            <i class="fa fa-send mr-5"></i> Open ticket
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </main>
            <?php include("@/inc/footer.php"); ?>
        </div>
        <?php include("@/inc/scripts.php"); ?>
        <?php if(empty($_GET["id"])){ ?>
        <script>
            var PageLoaded = false;
            $(document).ready(function () {
                PageLoaded = true;
                DoCaptcha();
                A_Disabled(false);
            });
            var gateway = 0;
            var token = 0;
            var btn = document.getElementById("doTicket");
            var subject = document.getElementById("subject");
            var categorie = document.getElementById("categorie");
            var message = document.getElementById("message");
            var response = document.getElementById("response");
            var captchacode = document.getElementById("captchaCode");
            function OpenTicket() {
                if (PageLoaded == true) {
                    response.innerHTML = '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Creating your ticket...</div>';
                    A_Disabled(true);
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4) {
                            A_Disabled(false);
                            if (this.status == 200) {
                                response.innerHTML = "";
                                var jsonResponse = this.responseText;
                                if (IsValidJson(jsonResponse)) {
                                    jsonResponse = JSON.parse(jsonResponse);
                                    if (jsonResponse.hasOwnProperty('msg_type') && jsonResponse.hasOwnProperty('msg')) {
                                        response.innerHTML = HtmlAlert(jsonResponse.msg_type, jsonResponse.msg);
                                    }
                                    if (jsonResponse.hasOwnProperty('go')) {
                                        window.location.href = jsonResponse.go;
                                    }
                                }
                                DoCaptcha();
                            } else {
                                response.innerHTML = '<div class="alert alert-danger">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>';
                            }
                            captchacode.value = "";
                        }
                    };
                    xmlhttp.open("POST", "@/inc/ajax/ticket.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("action=create&categorie="+categorie.value+"&subject=" + subject.value + "&message=" + message.value + "&token=" + token + "&captchacode=" + captchacode.value + "&gate=" + gateway);
                }
            }

            function A_Disabled(state) {
                subject.disabled = state;
                message.disabled = state;
                categorie.disabled = state;
                btn.disabled = state;
                captchacode.disabled = state;
            }

            function DoCaptcha() {
                A_Disabled(true);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            var jsonResponse = this.response;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('gate') && jsonResponse.hasOwnProperty('dataimg')) {
                                    var imagedata = jsonResponse.dataimg;
                                    if (imagedata.startsWith("data:image/png;")) {
                                        A_Disabled(false);
                                        document.getElementById("captchaImage").innerHTML = '<img src="' + imagedata + '" style="width: 100%;" alt="Captcha" />';
                                        gateway = jsonResponse.gate;
                                        token = jsonResponse.token;
                                    } else { response.innerHTML = '<div class="alert alert-danger">Unexpected captcha image, please try-again or reload your page.</div>'; }
                                } else { response.innerHTML = '<div class="alert alert-danger">An error has occured. Please try agin.</div>'; }
                            } else { response.innerHTML = '<div class="alert alert-danger">Unexpected reply, please try-again or reload your page.</div>'; }
                        } else { response.innerHTML = '<div class="alert alert-danger">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>'; }
                    }
                };
                xmlhttp.open("GET", "@/inc/gateway/key.php", true);
                xmlhttp.send();
            }
        </script>
        <?php }else{ ?>
        <script>var ticketid = <?php echo $ticket["publicid"]; ?>;</script>
        <script>
            var PageLoaded = false;
            $(document).ready(function () {
                PageLoaded = true;
                DoCaptcha();
                A_Disabled(false);
            });
            var gateway = 0;
            var token = 0;
            var btn = document.getElementById("doReply");
            var message = document.getElementById("message");
            var response = document.getElementById("response");
            var captchacode = document.getElementById("captchaCode");
            function ReplyToTicket() {
                if (PageLoaded == true) {
                    response.innerHTML = '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Creating your ticket...</div>';
                    A_Disabled(true);
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function () {
                        if (this.readyState == 4) {
                            A_Disabled(false);
                            if (this.status == 200) {
                                response.innerHTML = "";
                                var jsonResponse = this.responseText;
                                if (IsValidJson(jsonResponse)) {
                                    jsonResponse = JSON.parse(jsonResponse);
                                    if (jsonResponse.hasOwnProperty('msg_type') && jsonResponse.hasOwnProperty('msg')) {
                                        response.innerHTML = HtmlAlert(jsonResponse.msg_type, jsonResponse.msg);
                                    }
                                    if (jsonResponse.hasOwnProperty('go')) {
                                        window.location.href = jsonResponse.go;
                                    }
                                }
                                DoCaptcha();
                            } else {
                                response.innerHTML = '<div class="alert alert-danger">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>';
                            }
                            captchacode.value = "";
                        }
                    };
                    xmlhttp.open("POST", "@/inc/ajax/ticket.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.send("action=reply&id="+ticketid+ "&message=" + message.value + "&token=" + token + "&captchacode=" + captchacode.value + "&gate=" + gateway);
                }
            }

            function A_Disabled(state) {
                message.disabled = state;
                btn.disabled = state;
                captchacode.disabled = state;
            }

            function DoCaptcha() {
                A_Disabled(true);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            var jsonResponse = this.response;
                            if (IsValidJson(jsonResponse)) {
                                jsonResponse = JSON.parse(jsonResponse);
                                if (jsonResponse.hasOwnProperty('gate') && jsonResponse.hasOwnProperty('dataimg')) {
                                    var imagedata = jsonResponse.dataimg;
                                    if (imagedata.startsWith("data:image/png;")) {
                                        A_Disabled(false);
                                        document.getElementById("captchaImage").innerHTML = '<img src="' + imagedata + '" alt="Captcha" />';
                                        gateway = jsonResponse.gate;
                                        token = jsonResponse.token;
                                    } else { response.innerHTML = '<div class="alert alert-danger">Unexpected captcha image, please try-again or reload your page.</div>'; }
                                } else { response.innerHTML = '<div class="alert alert-danger">An error has occured. Please try agin.</div>'; }
                            } else { response.innerHTML = '<div class="alert alert-danger">Unexpected reply, please try-again or reload your page.</div>'; }
                        } else { response.innerHTML = '<div class="alert alert-danger">An error has occured. Reload your page and try again. If the problem persist, contact an admin.</div>'; }
                    }
                };
                xmlhttp.open("GET", "@/inc/gateway/key.php", true);
                xmlhttp.send();
            }
        </script>
        <?php } ?>
    </body>
</html>