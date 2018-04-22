#Mencari Bad Chracter
def generateBadCharShift(term):
    skipList = {}
    for i in range(0, len(term)-1):
        skipList[term[i]] = len(term)-i-1
    return skipList

#Mencari Good Suffix
def findSuffixPosition(badchar, suffix, full_term):
    for offset in range(1, len(full_term)+1)[::-1]:
        flag = True
        for suffix_index in range(0, len(suffix)):
            term_index = offset-len(suffix)-1+suffix_index
            if term_index < 0 or suffix[suffix_index] == full_term[term_index]:
                pass
            else:
                flag = False
        term_index = offset-len(suffix)-1
        if flag and (term_index <= 0 or full_term[term_index-1] != badchar):
            return len(full_term)-offset+1

def generateSuffixShift(key):
    skipList = {}
    buffer = ""
    for i in range(0, len(key)):
        skipList[len(buffer)] = findSuffixPosition(key[len(key)-1-i], buffer, key)
        buffer = key[len(key)-1-i] + buffer
    return skipList
    
# Algoritma pencarian
def BMSearch(text, pattern):
    goodSuffix = generateSuffixShift(pattern)
    badChar = generateBadCharShift(pattern)
    i = 0
    while i < len(text)-len(pattern)+1:
        j = len(pattern)
        while j > 0 and pattern[j-1] == text[i+j-1]:
            j -= 1
        if j > 0:
            badCharShift = badChar.get(text[i+j-1], len(pattern))
            goodSuffixShift = goodSuffix[len(pattern)-j]
            if badCharShift > goodSuffixShift:
                i += badCharShift
            else:
                i += goodSuffixShift
        else:
            return i
    return -1

# Program Utama 
if __name__ == "__main__":
    text = "Tubes tiada henti-hentinya"
    pattern = "tinya"
    print ("Text masukan adalah: ", text, ".")
    print ("Text yang dicari adalah: ", pattern, BMSearch(text, pattern))