<div class="modal fade" id="user_profile_modal_edit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="user_profile_modal_editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="user_profile_modal_edit_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="container" id="user_details_update_form">

                    <div class="row">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div id="user_p_img_l" class="d-flex justify-content-center align-items-center">
                                
                            </div>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12 items" id="item1">
                            <div class="form-floating">
                                <input type="text" class="form-control input_item" name="user_p_name" id="user_p_name" placeholder="Name">
                                <label for="user_p_name">Name</label>
                            </div>
                            <span class="error-r" id="error1">Error text</span>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12 items" id="item2">
                            <div class="form-floating">
                                <input type="email" class="form-control input_item" id="user_p_email" placeholder="Email ID" value="demo@" readonly>
                                <label for="user_p_email">email</label>
                            </div>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12 items" id="item3">
                            <div class="form-floating">
                                <span class="material-icons position-absolute date_picker_icon">date_range</span>
                                <input type="text" name="user_p_dob" class="form-control input_item date_picker" id="user_p_dob" placeholder="DOB" autocomplete="off">
                                <label for="dob" class="user_p_dob">DOB</label>
                            </div>
                            <span class="error-r" id="error2">Error text</span>
                        </div>
                    </div>


                    <div class="row my-4">
                        <div class="col-12 items" id="item4">
                            <div class="form-floating">
                                <select class="form-select input_item" id="user_p_gender" name="user_p_gender">
                                    <option selected value="1">Select the Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <label for="user_p_gender">Gender</label>
                            </div>
                            <span class="error-r" id="error3">Error text</span>
                        </div>
                    </div>

                    <div class="row mt-4 mb-2">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-primary me-3" id="user_p_u_btn_">Update Your Profile Details</button>
                            <button type="button" class="btn btn-dark ms-3" id="change_user_password_btn_">Change Your Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--change_password_modal_d -->
<div class="modal fade" id="change_password_modal_d" tabindex="-1" data-bs-backdrop="static" aria-labelledby="change_password_modal_dLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="change_password_modal_d_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="container" id="change_password_m_form">
                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-12 items" id="item_n_3">
                                <div class="form-floating">
                                    <input type="password" class="form-control input_item" name="user_p_password" id="user_p_password" placeholder="Enter The New Password">
                                    <label for="user_p_password">Enter The New Password</label>
                                </div>
                                <span class="error-r" id="error_n_2">Error text</span>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col d-flex justify-content-end align-items-center">
                                <input class="form-check-input me-2" type="checkbox" id="show_p_password">
                                <label for="show_p_password">Show password</label>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary" id="change_password_btn_">Change Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--p_verify_you_modal_d -->
<div class="modal fade" id="p_verify_you_modal_d" tabindex="-1" data-bs-backdrop="static" aria-labelledby="p_verify_you_modal_dLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="p_verify_you_modal_d_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="container" id="p_v_form">
                    <div class="row">
                        <div class="col-12">
                            <h3 id="your_user_name_t_p" class="text-center text-decoration-underline">Hi Tathagata Bandyopadhyay</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">To continue, first verify it’s you</div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 items" id="item_v3">
                            <div class="form-floating">
                                <input type="password" class="form-control input_item" name="v_user_p_password" id="v_user_p_password" placeholder="Enter Your Password">
                                <label for="v_user_p_password">Enter Your Password</label>
                            </div>
                            <span class="error-r" id="error_p_v">Error text</span>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col d-flex justify-content-end align-items-center">
                            <input class="form-check-input me-2" type="checkbox" id="show_p_password_v">
                            <label for="show_p_password_v">Show password</label>
                        </div>
                    </div>

                    <div class="row mt-4 mb-2">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-primary" id="user_verify_btn_">Verify Your Password</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>




<!-- date-picker Modal -->
<div class="modal fade" id="date_picker_modal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" id="date_modal_dialog">
        <div class="modal-content border-0">
            <div class="modal-header text-white" style="background-color: var(--date_picket_header_light_bg-color);">
                <div class="container" style="user-select: none;">
                    <div class="row">
                        <div class="col">
                            <span id="year"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex fw-bold fs-3">
                            <div id="day_name"></div>
                            <div>,</div>
                            <div id="date_name" class="mx-2"></div>
                            <div id="month_name"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body position-relative" id="date_modal_body">
                <div id="year_list" class="position-absolute">

                </div>
                <div id="month_list" class="position-absolute">

                </div>
                <div class="container-fluid p-0">
                    <div class="row fw-bold fs-6 align-items-center">
                        <button class="col-2 p_n_date" id="prev_date">
                            <span class="material-icons active_css_icon">
                                expand_less
                            </span>
                        </button>
                        <div class="col text-center" id="change_m_y"></div>
                        <button class="col-2 p_n_date" id="next_date">
                            <span class="material-icons active_css_icon">
                                expand_less
                            </span>
                        </button>
                    </div>
                    <div class="week_list mt-3">
                        <div class="week_m">S</div>
                        <div class="week_m">M</div>
                        <div class="week_m">T</div>
                        <div class="week_m">W</div>
                        <div class="week_m">T</div>
                        <div class="week_m">F</div>
                        <div class="week_m">S</div>
                    </div>
                    <div class="data_picker">
                        <span class="data_picker_span"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" id="set_date">SET</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_date_picker_modal">CANCEL</button>
                <button type="button" class="btn btn-primary" id="clear_date_picker">CLEAR</button>
            </div>
        </div>
    </div>
</div>