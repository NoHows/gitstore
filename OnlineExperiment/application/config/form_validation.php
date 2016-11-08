<?php  
$config = array(
                 'admin_knowledge_point/add' => array(
                                    array(
                                            'field' => 'content',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[400]'
                                         )
                                    ),
                 'admin_knowledge_point/edit' => array(
                                    array(
                                            'field' => 'content',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[400]'
                                         )
                                    ),
                 'admin_test_point/add' => array(
                                    array(
                                            'field' => 'content',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[400]'
                                         )
                                    ) ,
                 'admin_test_point/edit' => array(
                                    array(
                                            'field' => 'content',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[400]'
                                         )
                                    )  ,
                 'admin_module/add' => array(
                                    array(
                                            'field' => 'module_name',
                                            'label' => '名称',
                                            'rules' => 'required|max_length[200]'
                                         ),
                                    array(
                                            'field' => 'module_sort',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[200]'
                                         ),
                                    array(
                                            'field' => 'big_lecture_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         )
                                    
                                    )  ,
                 'admin_module/edit' => array(
                                    array(
                                            'field' => 'module_name',
                                            'label' => '名称',
                                            'rules' => 'required|max_length[200]'
                                         ),
                                    array(
                                            'field' => 'module_sort',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[200]'
                                         )
                                    
                                    ) ,
                 'admin_question/add' => array(
                                    array(
                                            'field' => 'content_main',
                                            'label' => '题干',
                                            'rules' => 'required|max_length[600]'
                                         ),
                                    array(
                                            'field' => 'content_1',
                                            'label' => 'Content',
                                            'rules' => 'max_length[400]'
                                         ),
                                    array(
                                            'field' => 'content_2',
                                            'label' => 'Content',
                                            'rules' => 'max_length[400]'
                                         ),
                                    array(
                                            'field' => 'content_3',
                                            'label' => 'Content',
                                            'rules' => 'max_length[400]'
                                         ),
                                    array(
                                            'field' => 'content_4',
                                            'label' => 'Content',
                                            'rules' => 'max_length[400]'
                                         )
                                    ),
                'admin_question/edit' => array(
                                    array(
                                            'field' => 'content_main',
                                            'label' => '题干',
                                            'rules' => 'required|max_length[600]'
                                         ),
                                    array(
                                            'field' => 'content_1',
                                            'label' => 'Content',
                                            'rules' => 'max_length[400]'
                                         ),
                                    array(
                                            'field' => 'content_2',
                                            'label' => 'Content',
                                            'rules' => 'max_length[400]'
                                         ),
                                    array(
                                            'field' => 'content_3',
                                            'label' => 'Content',
                                            'rules' => 'max_length[400]'
                                         ),
                                    array(
                                            'field' => 'content_4',
                                            'label' => 'Content',
                                            'rules' => 'max_length[400]'
                                         )
                                    ),
                'admin_teacher/add' => array(
                                    array(
                                            'field' => 'teacher_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'major_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'teacher_number',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]|callback_teacher_number_check'
                                         ),
                                    ),
                'admin_teacher/edit' => array(
                                    array(
                                            'field' => 'teacher_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'major_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         )
                                    ),
                'admin_class/class_add' => array(
                                    array(
                                            'field' => 'class_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    ),
                'admin_class/class_edit' => array(
                                    array(
                                            'field' => 'class_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    ),
                'admin_class/major_add' => array(
                                    array(
                                            'field' => 'major_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    ),
                'admin_class/major_edit' => array(
                                    array(
                                            'field' => 'major_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    ),
                'admin_class/logic_class_add' => array(
                                    array(
                                            'field' => 'logic_class_number',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]|callback_logic_class_number_check'
                                         ),
                                    array(
                                            'field' => 'teacher_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'logic_class_type',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'big_lecture_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    
                                    ),
                 'admin_class/logic_class_edit' => array(
                                    array(
                                            'field' => 'logic_class_number',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'teacher_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'logic_class_type',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'big_lecture_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    ),
                 'admin_student/add' => array(
                                    array(
                                            'field' => 'student_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'student_id',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]|callback_student_id_check'
                                         ),
                                    array(
                                            'field' => 'major_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'class_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    ),
                'admin_student/edit' => array(
                                    array(
                                            'field' => 'student_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'major_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'class_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    ),
                'admin_home/change_password' => array(
                                    array(
                                            'field' => 'old_password',
                                            'label' => 'old_password',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'new_password',
                                            'label' => 'new_password',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'new_password_confirm',
                                            'label' => 'new_password_confirm',
                                            'rules' => 'required|max_length[45]|matches[new_password]'
                                         ),
                                    ),
'admin_password/change_password' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => 'username',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'new_password',
                                            'label' => 'new_password',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'new_password_confirm',
                                            'label' => 'new_password_confirm',
                                            'rules' => 'required|max_length[45]|matches[new_password]'
                                         ),
                                    ),
                'teacher_student/add' => array(
                                    array(
                                            'field' => 'student_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'student_id',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'major_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    ),
                'teacher_student/edit' => array(
                                    array(
                                            'field' => 'student_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'major_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'class_id',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    ),
                 'teacher_class/class_add' => array(
                                    array(
                                            'field' => 'class_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    ),
                'teacher_class/class_edit' => array(
                                    array(
                                            'field' => 'class_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    ),
                'teacher_class/major_add' => array(
                                    array(
                                            'field' => 'major_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    ),
                'teacher_class/major_edit' => array(
                                    array(
                                            'field' => 'major_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    ),
                'teacher_class/logic_class_add' => array(
                                    array(
                                            'field' => 'logic_class_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'logic_class_number',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]|callback_logic_class_number_check'
                                         ),
                                    array(
                                            'field' => 'logic_class_type',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    ),
                 'teacher_class/logic_class_edit' => array(
                                    array(
                                            'field' => 'logic_class_name',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'logic_class_number',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'logic_class_type',
                                            'label' => 'Content',
                                            'rules' => 'required'
                                         ),
                                    ),
                 'teacher_module/edit' => array(
                                    array(
                                            'field' => 'module_name',
                                            'label' => '名称',
                                            'rules' => 'required|max_length[200]'
                                         ),
                                    array(
                                            'field' => 'module_time_limit',
                                            'label' => 'Content',
                                            'rules' => 'required|greater_than[4]|less_than[101]'
                                         )
                                    ),
                 'admin_class/add_big_lecture' => array(
                                    array(
                                            'field' => 'big_lecture_name',
                                            'label' => '名称',
                                            'rules' => 'required|max_length[100]'
                                         ),
                                    
                                    ),
                 'admin_class/big_lecture_edit' => array(
                                    array(
                                            'field' => 'big_lecture_name',
                                            'label' => '名称',
                                            'rules' => 'required|max_length[100]'
                                         ),
                                    
                                    ),
                 'teacher_performance/export_all_grades' => array(
                                    array(
                                            'field' => 'logic_class_id',
                                            'label' => '名称',
                                            'rules' => 'required'
                                         ),
                                    
                                    ),
                 'teacher_home/change_password' => array(
                                    array(
                                            'field' => 'old_password',
                                            'label' => 'old_password',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'new_password',
                                            'label' => 'new_password',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'new_password_confirm',
                                            'label' => 'new_password_confirm',
                                            'rules' => 'required|max_length[45]|matches[new_password]'
                                         ),
                                    ),
                'student_home/change_password' => array(
                                    array(
                                            'field' => 'old_password',
                                            'label' => 'old_password',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'new_password',
                                            'label' => 'new_password',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'new_password_confirm',
                                            'label' => 'new_password_confirm',
                                            'rules' => 'required|max_length[45]|matches[new_password]'
                                         ),
                                    ),
                'register/student_register' => array(
                                    array(
                                            'field' => 'username',
                                            'label' => 'username',
                                            'rules' => 'required|max_length[45]|callback_username_check'
                                         ),
                                    array(
                                            'field' => 'name',
                                            'label' => 'name',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'password',
                                            'rules' => 'required|max_length[45]'
                                         ),
                                     array(
                                            'field' => 'password_confirm',
                                            'label' => 'password_confirm',
                                            'rules' => 'required|max_length[45]|matches[password]'
                                         ),
                                    ),
                /*'Model' => array(
                                    array(
                                            'field' => 'content',
                                            'label' => 'Content',
                                            'rules' => 'required|max_length[200]'
                                         ),
                                    array(
                                            'field' => 'name',
                                            'label' => 'Name',
                                            'rules' => 'required|alpha'
                                         ),
                                    array(
                                            'field' => 'title',
                                            'label' => 'Title',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'message',
                                            'label' => 'MessageBody',
                                            'rules' => 'required'
                                         )
                                    )          */                                      
               );