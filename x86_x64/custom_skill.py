 # !/usr/bin/python
# -*- coding: utf-8 -*-
#-*-coding:gb2312-*-
#Processing
import libs
files = ['config.json', 'object.json', 'skill.json', 'action.json', 'adverb.json']
data = {}
for file in files:
    with open(file) as json_file:
        data[file] = libs.json.load(json_file)
conf_data = data.get('config.json', {})
obj_data = data.get('object.json', {})
skill_data = data.get('skill.json', {})
act_data = data.get('action.json', {})
adv_data = data.get('adverb.json', {})

def custom_skill_1(data):#Def này sẽ trả về kết quả để Vietbot đọc nội dung
    return data


if __name__ == '__main__':  
    data-'test_skill'
    print(custom_skill_1(data))