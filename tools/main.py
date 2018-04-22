import sys
sys.path.append('tools/algorithm')
# sys.path.append('tools/json')

import json
import re
from kmp import kmp_strmat
from BoyerMoore import BMSearch

def chooser(mode,patt,tweet) :
    if (mode == "kmp") :
        return (kmp_strmat(patt, tweet) != -1)
    elif (mode == "bm") :
        return (BMSearch(patt, tweet) != -1)
    elif (mode == "regex") :
        return (re.match(patt,tweet))

if __name__ == "__main__" :
    data = json.load(open('tools/json/result_api.json'))
    howto = json.load(open('tools/json/user_input.json'))
    tarr = []
    mode = howto['algorithm']
    if (mode != "regex") :
        patt = howto['keyword'].lower() 
    else :
        patt = howto['keyword']
    for a in range(len(data)) :
        tweet = data[a]['text'].lower()
        isSpam = chooser(mode,patt,tweet)
        ResObject = dict()
        ResObject['spam'] = isSpam
        ResObject['text'] = data[a]['text']
        ResObject['username'] = data[a]['user']['screen_name']
        ResObject['name'] = data[a]['user']['name']
        tarr.append(ResObject)
    # print(tarr)
    res_file = open("tools/json/final_result.json","w")
    json.dump(tarr, res_file)
    res_file.close()
            

