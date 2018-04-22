def kmp_strmat(pat,text) :
    # border function
    borarr = [0]
    for char in pat[1 :] :
        k = borarr[-1]
        while k > 0 and char != pat[k] :
            k = borarr[k-1]
        if char == pat[k] :
            k += 1
        borarr.append(k)

    # matching process
    m = 0 # num of char matched
    for p in range(len(text)) :
        while m > 0 and pat[m] != text[p] :
            m = borarr[m-1]
        if pat[m] == text[p] :
            m += 1
            if m == len(pat) :
                q = p-m+1
                return q

    return -1