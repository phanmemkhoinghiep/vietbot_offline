Cấu hình trong file "sensors.yaml" theo mẫu dưới đây:
(Lưu ý: thay địa chỉ http://192.168.14.194 thành địa chỉ loa Vietbot của bạn)

    - platform: command_line
      name: Vietbot API info
      command: "curl -X POST -H 'Content-Type: application/json' -d '{\"query\": \"info\", \"api_key\": \"3f406f61a2b5053b53cda80e0320a60b\"}' http://192.168.14.194/API.php"
      command_timeout: 40
      value_template: "{{ value_json.message }}"
      scan_interval:
        minutes: 180
      json_attributes:
        - message
        - http_response_code
        - output_api
        - info_vietbot
        - info_os
        - information

Tạo Automation thông báo khi có phiên bản mới:

Cấu hình trong automation.yaml

->Automation Thông Báo Vietbot Có Cập Nhật Mới:

    - id: '564654656576576575643f3f'
      alias: Thông báo có phiên bản cập nhật Phiên Bản Vietbot
      trigger:
        - platform: state
          entity_id: sensor.vietbot_api_info
      condition:
        - condition: template
          value_template: "{{ trigger.to_state.attributes.info_vietbot.vietbot_version.check_for_updates == True }}"
          #value_template: "{{ state_attr('sensor.vietbot_api_info', 'info_vietbot')['vietbot_version']['check_for_updates'] == True }}"
      action:
        - service: notify.mobile_app_iphone_6s_vu_tuyen
          data:
            title: "Vietbot:"
            message: "Có phiên bản mới: {{ state_attr('sensor.vietbot_api_info', 'info_vietbot')['vietbot_version']['new_version']}}"

->Automation Thông Báo  Có Cập Nhật Giao Diện Web UI Mới:

    - id: '5646546543f3f'
      alias: Thông báo về phiên bản mới của giao diện UI của Vietbot
      trigger:
        - platform: state
          entity_id: sensor.vietbot_api_info
      condition:
        - condition: template
          value_template: "{{ trigger.to_state.attributes.info_vietbot.ui_version.check_for_updates == True }}"
          #value_template: "{{ state_attr('sensor.vietbot_api_info', 'info_vietbot')['ui_version']['check_for_updates'] == True }}"
      action:
        - service: notify.mobile_app_iphone_6s_vu_tuyen
          data:
            title: "Vietbot Web UI:"
            message: "Có phiên bản giao diện mới: {{ state_attr('sensor.vietbot_api_info', 'info_vietbot')['ui_version']['new_version']}}"


Giao Diện Love Lace:

    type: horizontal-stack
    cards:
      - type: markdown
        content: >-
          <center><b><font color=Yellow>Loa Thông Minh Vietbot</font></b></center>

          Phiên Bản Vietbot:<font color=gree> {{
          state_attr('sensor.vietbot_api_info','info_vietbot').vietbot_version.current_version}}</font><br/>


          - <font color=gree>  {% if state_attr('sensor.vietbot_api_info',
          'info_vietbot').vietbot_version.new_version is none %}
            Không có phiên bản mới
            {% else %}
            Có phiên bản Vietbot mới: {{ state_attr('sensor.vietbot_api_info', 'info_vietbot').vietbot_version.new_version }}</font><br/>
            - Cập Nhật Lệnh: <font color=gree>{{ state_attr('sensor.vietbot_api_info', 'info_vietbot').vietbot_version.content.update_command }}</font><br/>
            - Tính Năng Mới: <font color=gree>{{ state_attr('sensor.vietbot_api_info', 'info_vietbot').vietbot_version.content.new_features }}</font><br/>
            - Sửa Lỗi: <font color=gree>{{ state_attr('sensor.vietbot_api_info', 'info_vietbot').vietbot_version.content.bug_fixed }}</font><br/>
            - Cải Tiến: <font color=gree>{{ state_attr('sensor.vietbot_api_info', 'info_vietbot').vietbot_version.content.improvements }}</font>
            {% endif %}</font><br/>
        
          Phiên Bản Giao Diện Web UI: <font color=gree> {{
          state_attr('sensor.vietbot_api_info','info_vietbot').ui_version.current_version}}</font><br/>


          - <font color=gree>  {% if state_attr('sensor.vietbot_api_info',
          'info_vietbot').ui_version.new_version is none %}
            Không có phiên bản mới
            {% else %}
            Có phiên bản WEB UI mới: {{ state_attr('sensor.vietbot_api_info', 'info_vietbot').ui_version.new_version }}</font><br/>
            {{ state_attr('sensor.vietbot_api_info', 'info_vietbot').ui_version.content }}{% endif %}</font><br/>

          Cập Nhật Cuối: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','information').last_update_time}}'</font>

          <hr> Thông Tin Hệ Thống:<br/>

      
          - Bộ Nhớ:<br/> - Tổng Dung Lượng: <font
          color=gree>{{state_attr('sensor.vietbot_api_info','info_os').disk.disk_total}}</font><br/>
          - Đã Dùng: <font
          color=gree>{{state_attr('sensor.vietbot_api_info','info_os').disk.disk_used}}</font><br/>
          - Còn Lại: <font
          color=gree>{{state_attr('sensor.vietbot_api_info','info_os').disk.disk_free}}</font><br/>

          - RAM:<br/> - Tổng Dung Lượng: <font
          color=gree>{{state_attr('sensor.vietbot_api_info','info_os').ram.ram_total}}</font><br/>
          - Đã Dùng: <font
          color=gree>{{state_attr('sensor.vietbot_api_info','info_os').ram.ram_used}}</font><br/>
          - Còn Lại: <font
          color=gree>{{state_attr('sensor.vietbot_api_info','info_os').ram.ram_free}}</font><br/>

          - Dung Lượng CPU Đã Dùng: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').used_cpu_capacity}}</font>
          - Host Name: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').host_name}}</font>
          - Server Name: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').server_name}}</font>
          - Phiên Bản Kernel: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').kernel_version}}</font>
          - Machine Type: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').machine_type}}</font>
          - Phiên Bản OS: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').os_version}}</font>
          - Phiên Bản PHP: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').php_version}}</font>
          - Phiên Bản API: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','information').api_version}}</font>
          - Uname -a: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').uname_a}}</font>
          - Thời Gian Hoạt Động: <font color=gree>{{
                state_attr('sensor.vietbot_api_info','info_os').uptime}}</font>
