<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION["user_email"])) {
    header("Location:index");
}
?>


<div class="modal fade" id="message_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="message_modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen custom_dialog_">
    <div class="modal-content">
      <div class="modal-header">
          <div class="container">
              <div class="row">
                  <div class="col p-0 d-flex justify-content-end">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="message_modal_close_icon"></button>
                  </div>
              </div>
              <div class="row">
                  <div class="col p-0 d-flex justify-content-center">
                      <h5 class="modal-title" id="message_modalLabel">Message Box</h5>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-body p-0 custom_body_">
        <div class="area">
            <ul class="circles">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <div id="message_user_ele">
            <div class="container">
                <div class="row position-sticky top-0 start-0">
                    <div class="col-12 my-3">
                        <input type="text" id="search_user_in_message" placeholder="Search Friends">
                    </div>
                </div>
            </div>

            <div class="message_user_ele1 container">
                <!-- <div class="row my-3">
                    <div class="col-12">
                        <div class="message_user_div__ele d-flex justify-content-between align-items-center" data-fid=''>
                            <div class="message_user_ele_with_img d-flex align-items-center justify-content-start">
                                <div class="message_user__profile_img_">
                                    <img src="img/profile_img/default_image1.jpg">
                                    <div class="message_user__profile_img_text_">T</div>
                                </div>
                                <div class="message_user_name_with_mess">
                                    <div class="message_user__name_">Tathagata Bandyopadhyay</div>
                                    <div class="user_send_or_receive_mess_name">Hello</div>
                                </div>
                            </div>
                            <div class="message_time_ago">1 hours ago</div>
                        </div>
                    </div>
                </div> 

                <div class="row my-3">
                    <div class="col-12">
                        <div class="message_user_div__ele d-flex justify-content-between align-items-center" data-fid=''>
                            <div class="message_user_ele_with_img d-flex align-items-center justify-content-start">
                                <div class="message_user__profile_img_">
                                    <img src="img/profile_img/default_image1.jpg">
                                    <div class="message_user__profile_img_text_">T</div>
                                </div>
                                <div class="message_user_name_with_mess">
                                    <div class="message_user__name_">Tathagata Bandyopadhyay</div>
                                    <div class="user_send_or_receive_mess_name">Hello</div>
                                </div>
                            </div>
                            <div class="message_time_ago">1 hours ago</div>
                        </div>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-12">
                        <div class="message_user_div__ele_n d-flex justify-content-center align-items-center">
                            No Friends Founds
                        </div>
                    </div>
                </div> -->

            </div>

            <div class="message_user_ele2 container">

                <!-- <div class="row my-3">
                    <div class="col-12">
                        <div class="message_user_div__ele d-flex justify-content-between align-items-center" data-fid=''>
                            <div class="message_user_ele_with_img d-flex align-items-center justify-content-start">
                                <div class="message_user__profile_img_">
                                    <img src="img/profile_img/default_image1.jpg">
                                    <div class="message_user__profile_img_text_">T</div>
                                </div>
                                <div class="message_user_name_with_mess">
                                    <div class="message_user__name_">Tathagata Bandyopadhyay</div>
                                    <div class="user_send_or_receive_mess_name">Hello</div>
                                </div>
                            </div>
                            <div class="message_time_ago">1 hours ago</div>
                        </div>
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-12">
                        <div class="message_user_div__ele d-flex justify-content-between align-items-center" data-fid=''>
                            <div class="message_user_ele_with_img d-flex align-items-center justify-content-start">
                                <div class="message_user__profile_img_">
                                    <img src="img/profile_img/default_image1.jpg">
                                    <div class="message_user__profile_img_text_">T</div>
                                </div>
                                <div class="message_user_name_with_mess">
                                    <div class="message_user__name_">Tathagata Bandyopadhyay</div>
                                    <div class="user_send_or_receive_mess_name">Hello</div>
                                </div>
                            </div>
                            <div class="message_time_ago">1 hours ago</div>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
        <div id="message_details_ele">
            <div class="message_user_details_top container">
                <div class="row">
                    <div class="col-12 d-flex align-items-center py-2" style="background-color: #ffffffad;box-shadow: 0px 1px 5px 0px #000000ba, 0px 1px 5px 0px #fff, 0px 1px 5px 0px #000000ba;">
                        <div id="arrow_back_btn" class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                        <div class="user_details_in_message__top d-flex align-items-center ms-3">
                            <div class="user_details_in_message__top_img_text_ele">
                                <img src="img/profile_img/default_image.jpg">
                                <!-- <div class="user_details_in_message__top_img_text">T</div> -->
                            </div>
                            <div class="user_details_in_message__top_friend_name_online d-flex flex-column">
                                <div class="user_details_in_message__top_friend_name" data-current_fid='0'>Jonty Banerjee</div>
                                <div class="user_details_in_message__top_friend_online_status">online</div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="message_user_details_middle container">

                <!-- <div class="row">
                    <div class="col-12 d-flex my-3">
                        <div class="user_chat_message">
                            <div class="user_message_description">Hi</div>
                            <div class="user_message_time_ago">1 month ago</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex my-3 chat_send_col">
                        <div class="user_chat_message chat_send">
                            <div class="user_message_description">Hi</div>
                            <div class="user_message_time_ago">1 month ago</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex my-3">
                        <div class="user_chat_message">
                            <div class="user_message_description">Hi</div>
                            <div class="user_message_time_ago">1 month ago</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex my-3">
                        <div class="user_chat_message">
                            <div class="user_message_description">Hi</div>
                            <div class="user_message_time_ago">1 month ago</div>
                        </div>
                    </div>
                </div> -->

                <!-- img and video -->
                <!-- <div class="row">
                    <div class="col-12 d-flex my-3">
                        <div class="user_chat_message">
                            <div class="user_message_description_img_video_style">
                                <img src="http://localhost/php/ume_chat/message_img_video_or_doc/1651458763_6623_Fullstack_Developer.png">
                                <video src="http://localhost/php/ume_chat/message_img_video_or_doc/1651458837_8023_Asphalt%209_%20Legends%202022-02-06%2019-32-12.mp4" controls=""></video>
                                <img src="post_img/1652702164_8232_bg.jpg">
                                <video src="post_img/1652702164_6329_video2.mp4" controls=""></video>
                            </div>
                            <div class="user_message_time_ago">1 month ago</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex my-3 chat_send_col">
                        <div class="user_chat_message chat_send">
                            <div class="user_message_description_img_video_style">
                                <img src="http://localhost/php/ume_chat/message_img_video_or_doc/1651458763_6623_Fullstack_Developer.png">
                                <video src="http://localhost/php/ume_chat/message_img_video_or_doc/1651458837_8023_Asphalt%209_%20Legends%202022-02-06%2019-32-12.mp4" controls=""></video>
                                <img src="post_img/1652702164_8232_bg.jpg">
                                <video src="post_img/1652702164_6329_video2.mp4" controls=""></video>
                            </div>
                            <div class="user_message_time_ago">1 month ago</div>
                        </div>
                    </div>
                </div> -->

                <!-- document -->
                <!-- <div class="row">
                    <div class="col-12 d-flex my-3">
                        <div class="user_chat_message">
                            <div class="user_message_description_document_style">
                                <div class="doc_content">
                                    <div class="document_icon">
                                        <span class="material-symbols-outlined">description</span>
                                    </div>
                                    <div class="document_name">Screenshot (239).png</div>
                                </div>
                                <button data-document_src="1651458912_9910_Screenshot (239).png" class="download_icon">
                                    <img src="img/icon/download_icon.svg">
                                </button>
                            </div>
                            <div class="user_message_time_ago">1 month ago</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex my-3 chat_send_col">
                        <div class="user_chat_message chat_send">
                            <div class="user_message_description_document_style">
                                <div class="doc_content">
                                    <div class="document_icon">
                                        <span class="material-symbols-outlined">description</span>
                                    </div>
                                    <div class="document_name">Screenshot (239).png</div>
                                </div>
                                <button data-document_src="1651458912_9910_Screenshot (239).png" class="download_icon">
                                    <img src="img/icon/download_icon.svg">
                                </button>
                            </div>
                            <div class="user_message_time_ago">1 month ago</div>
                        </div>
                    </div>
                </div> -->

            </div>
            <div class="message_user_details_bottom container">
                <div class="row">
                    <div class="col-12 py-3 d-flex align-items-center" style="background: #ffffffad;box-shadow: 0px -1px 5px 0px #000000ba, 0px -1px 5px 0px #fff, 0px -1px 5px 0px #000000ba;">
                        <form id="u_send_message_from">
                            <input type="text" id="message_send_by_input" class="message_send_by_input_c" placeholder="Type a message" autocomplete="off">
                        </form>
                        <div id="message_all_doc_outer">
                            <img src="img/icon/paper-clip.svg" alt="" id="all_doc_img">
                            <form id="all_doc_inner">
                                <div id="form_inner">
                                    <label for="document_send_m" title="Document">
                                        <svg viewBox="0 0 53 53" width="53" height="53" class=""><defs><circle id="document-SVGID_1_" cx="26.5" cy="26.5" r="25.5"></circle></defs><clipPath id="document-SVGID_2_"><use xlink:href="#document-SVGID_1_" overflow="visible"></use></clipPath><g clip-path="url(#document-SVGID_2_)"><path fill="#5157AE" d="M26.5-1.1C11.9-1.1-1.1 5.6-1.1 27.6h55.2c-.1-19-13-28.7-27.6-28.7z"></path><path fill="#5F66CD" d="M53 26.5H-1.1c0 14.6 13 27.6 27.6 27.6s27.6-13 27.6-27.6H53z"></path></g><g fill="#F5F5F5"><path id="svg-document" d="M29.09 17.09c-.38-.38-.89-.59-1.42-.59H20.5c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H32.5c1.1 0 2-.9 2-2V23.33c0-.53-.21-1.04-.59-1.41l-4.82-4.83zM27.5 22.5V18l5.5 5.5h-4.5c-.55 0-1-.45-1-1z"></path></g></svg>
                                    </label>
                                    <input id="document_send_m" name="document_send_m[]" accept="*" type="file" multiple="" style="display: none;">

                                    <label for="image_send_c" title="Photo &amp; Video">
                                        <svg viewBox="0 0 53 53" width="53" height="53" class=""><defs><circle id="image-SVGID_1_" cx="26.5" cy="26.5" r="25.5"></circle></defs><clipPath id="image-SVGID_2_"><use xlink:href="#image-SVGID_1_" overflow="visible"></use></clipPath><g clip-path="url(#image-SVGID_2_)"><path fill="#AC44CF" d="M26.5-1.1C11.9-1.1-1.1 5.6-1.1 27.6h55.2c-.1-19-13-28.7-27.6-28.7z"></path><path fill="#BF59CF" d="M53 26.5H-1.1c0 14.6 13 27.6 27.6 27.6s27.6-13 27.6-27.6H53z"></path><path fill="#AC44CF" d="M17 24.5h18v9H17z"></path></g><g fill="#F5F5F5"><path id="svg-image" d="M18.318 18.25h16.364c.863 0 1.727.827 1.811 1.696l.007.137v12.834c0 .871-.82 1.741-1.682 1.826l-.136.007H18.318a1.83 1.83 0 0 1-1.812-1.684l-.006-.149V20.083c0-.87.82-1.741 1.682-1.826l.136-.007h16.364Zm5.081 8.22-3.781 5.044c-.269.355-.052.736.39.736h12.955c.442-.011.701-.402.421-.758l-2.682-3.449a.54.54 0 0 0-.841-.011l-2.262 2.727-3.339-4.3a.54.54 0 0 0-.861.011Zm8.351-5.22a1.75 1.75 0 1 0 .001 3.501 1.75 1.75 0 0 0-.001-3.501Z"></path></g></svg>
                                    </label>
                                    <input id="image_send_c" accept="image/png, image/jpeg,image/gif,video/mp4" name="image_send_m[]" type="file" multiple="multiple" style="display: none;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>