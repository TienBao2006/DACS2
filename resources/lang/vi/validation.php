<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Các thông báo lỗi mặc định cho các rule validation của Laravel.
    | Bạn có thể tùy chỉnh hoặc thêm các rule riêng tại đây.
    |
    */

    'accepted'             => ':attribute phải được chấp nhận.',
    'active_url'           => ':attribute không phải là URL hợp lệ.',
    'after'                => ':attribute phải là ngày sau :date.',
    'after_or_equal'       => ':attribute phải là ngày sau hoặc bằng :date.',
    'alpha'                => ':attribute chỉ được chứa chữ cái.',
    'alpha_dash'           => ':attribute chỉ được chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
    'alpha_num'            => ':attribute chỉ được chứa chữ cái và số.',
    'array'                => ':attribute phải là một mảng.',
    'before'               => ':attribute phải là ngày trước :date.',
    'before_or_equal'      => ':attribute phải là ngày trước hoặc bằng :date.',
    'between'              => [
        'numeric' => ':attribute phải nằm trong khoảng :min - :max.',
        'file'    => ':attribute phải nằm trong khoảng :min - :max kilobytes.',
        'string'  => ':attribute phải nằm trong khoảng :min - :max ký tự.',
        'array'   => ':attribute phải có từ :min đến :max phần tử.',
    ],
    'boolean'              => ':attribute phải là true hoặc false.',
    'confirmed'            => ':attribute xác nhận không khớp.',
    'date'                 => ':attribute không phải là ngày hợp lệ.',
    'date_equals'          => ':attribute phải là ngày bằng :date.',
    'date_format'          => ':attribute không đúng định dạng :format.',
    'different'            => ':attribute và :other phải khác nhau.',
    'digits'               => ':attribute phải gồm :digits chữ số.',
    'digits_between'       => ':attribute phải nằm trong khoảng :min và :max chữ số.',
    'dimensions'           => ':attribute có kích thước hình ảnh không hợp lệ.',
    'distinct'             => ':attribute có giá trị bị trùng lặp.',
    'email'                => ':attribute phải là một địa chỉ email hợp lệ.',
    'exists'               => ':attribute đã chọn không hợp lệ.',
    'file'                 => ':attribute phải là một tập tin.',
    'filled'               => ':attribute không được bỏ trống.',
    'gt'                   => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file'    => ':attribute phải lớn hơn :value kilobytes.',
        'string'  => ':attribute phải nhiều hơn :value ký tự.',
        'array'   => ':attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte'                  => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file'    => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string'  => ':attribute phải nhiều hơn hoặc bằng :value ký tự.',
        'array'   => ':attribute phải có ít nhất :value phần tử.',
    ],
    'image'                => ':attribute phải là một ảnh.',
    'in'                   => ':attribute không hợp lệ.',
    'in_array'             => ':attribute không tồn tại trong :other.',
    'integer'              => ':attribute phải là số nguyên.',
    'ip'                   => ':attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4'                 => ':attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6'                 => ':attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json'                 => ':attribute phải là một chuỗi JSON hợp lệ.',
    'lt'                   => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file'    => ':attribute phải nhỏ hơn :value kilobytes.',
        'string'  => ':attribute phải ít hơn :value ký tự.',
        'array'   => ':attribute phải có ít hơn :value phần tử.',
    ],
    'lte'                  => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file'    => ':attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string'  => ':attribute phải ít hơn hoặc bằng :value ký tự.',
        'array'   => ':attribute không được có nhiều hơn :value phần tử.',
    ],
    'max'                  => [
        'numeric' => ':attribute không được lớn hơn :max.',
        'file'    => ':attribute không được lớn hơn :max kilobytes.',
        'string'  => ':attribute không được dài hơn :max ký tự.',
        'array'   => ':attribute không được có nhiều hơn :max phần tử.',
    ],
    'mimes'                => ':attribute phải là tập tin có định dạng: :values.',
    'mimetypes'            => ':attribute phải là tập tin có định dạng: :values.',
    'min'                  => [
        'numeric' => ':attribute phải ít nhất :min.',
        'file'    => ':attribute phải ít nhất :min kilobytes.',
        'string'  => ':attribute phải ít nhất :min ký tự.',
        'array'   => ':attribute phải có ít nhất :min phần tử.',
    ],
    'not_in'               => ':attribute đã chọn không hợp lệ.',
    'not_regex'            => ':attribute có định dạng không hợp lệ.',
    'numeric'              => ':attribute phải là số.',
    'present'              => ':attribute phải có mặt.',
    'regex'                => ':attribute có định dạng không hợp lệ.',
    'required'             => ':attribute không được để trống.',
    'required_if'          => ':attribute không được để trống khi :other là :value.',
    'required_unless'      => ':attribute không được để trống trừ khi :other thuộc :values.',
    'required_with'        => ':attribute không được để trống khi có :values.',
    'required_with_all'    => ':attribute không được để trống khi có :values.',
    'required_without'     => ':attribute không được để trống khi không có :values.',
    'required_without_all' => ':attribute không được để trống khi không có bất kỳ :values nào.',
    'same'                 => ':attribute và :other phải giống nhau.',
    'size'                 => [
        'numeric' => ':attribute phải có kích thước bằng :size.',
        'file'    => ':attribute phải có kích thước bằng :size kilobytes.',
        'string'  => ':attribute phải có độ dài bằng :size ký tự.',
        'array'   => ':attribute phải chứa :size phần tử.',
    ],
    'string'               => ':attribute phải là chuỗi ký tự.',
    'timezone'             => ':attribute phải là múi giờ hợp lệ.',
    'unique'               => ':attribute đã tồn tại.',
    'uploaded'             => ':attribute tải lên thất bại.',
    'url'                  => ':attribute có định dạng không hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Bạn có thể đặt các thông báo validation riêng cho các trường cụ thể
    | bằng cách sử dụng cú pháp "attribute.rule" để tùy chỉnh thông báo.
    |
    */

    'custom' => [
        'username' => [
            'required' => 'Tên tài khoản không được để trống.',
            'unique' => 'Tên tài khoản đã tồn tại, vui lòng chọn tên khác.',
            'max' => 'Tên tài khoản không được vượt quá :max ký tự.',
        ],
        'password' => [
            'required' => 'Mật khẩu không được để trống.',
            'min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        ],
        'role' => [
            'required' => 'Bạn phải chọn vai trò.',
            'in' => 'Vai trò không hợp lệ.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | Đây là nơi để bạn định nghĩa tên hiển thị cho các trường (attribute)
    | khi hiển thị thông báo lỗi thay vì tên trường thực tế.
    |
    */

    'attributes' => [
        'username' => 'Tên tài khoản',
        'password' => 'Mật khẩu',
        'role' => 'Vai trò',
    ],

];
