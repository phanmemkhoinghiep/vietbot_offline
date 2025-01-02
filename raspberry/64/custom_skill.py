 # !/usr/bin/python
# -*- coding: utf-8 -*-
#Processing
from lib_process import requests,fuzz,datetime,math,fuzz,random,re, global_constants,print_out
def local_music(data):
    global music_cache
    for cached_data, cached_result in music_cache.items():
        if similarity_check(data, cached_data):
            return cached_result
    music_compare_result=[]
    words = data.split()
    data = ' '.join(word for word in words if word not in global_constants.act_play and word not in global_constants.obj_music )
    try:
        for i in range(len(global_constants.song_path_list)):
            match_ratio= fuzz.token_sort_ratio(data, global_constants.song_path_list[i].replace('.mp3','').lower())
            music_compare_result.append(match_ratio)
        # print(music_compare_result)    
        if max(music_compare_result) > global_constants.local_music_compare:
            song_path=global_constants.song_path_list[music_compare_result.index(max(music_compare_result))]
            return song_path.split('.mp3')[0].upper(),'mp3/'+song_path
        else:
            return 'Lỗi tìm kiếm bài hát',None       
    except Exception as e:
        return 'Lỗi tìm kiếm bài hát',None
