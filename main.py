import json
import re
from kmp import kmp_strmat

def chooser(mode,patt,tweet) :
    if (mode == "kmp") :
        return (kmp_strmat(patt,tweet) != -1)
    elif (mode == "regex") :
        return (re.match(patt,tweet))
     

if __name__ == "__main__" :
    data = json.load(open('test.json'))
    howto = json.load(open('user_input.json'))
    tarr = []
    mode = howto['algorithm']
    patt = howto['keyword']
    for a in range(len(data)) :
        tweet = data[a]['text']
        isSpam = chooser(mode,patt,tweet)
        ResObject = dict()
        ResObject['spam'] = isSpam
        ResObject['text'] = tweet
        ResObject['username'] = data[a]['user']['screen_name']
        ResObject['name'] = data[a]['user']['name']
        tarr.append(ResObject)
    print(tarr)
    res_file = open("res.json","w")
    json.dump(tarr,res_file)
    res_file.close()
            

