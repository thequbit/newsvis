import sys
import time

from bs4 import BeautifulSoup
import nltk

import urllib
import urllib2

from sources import sources;
from articles import articles;
from words import words;

#
# from: http://stackoverflow.com/questions/1342000/how-to-replace-non-ascii-characters-in-string
# via: http://stackoverflow.com/users/106979/fortran
#
def removeNonAscii(s):
    return "".join(i for i in s if ord(i)<128)

def getwords(text):
    textnonascii = removeNonAscii(text)
    scrubstr = textnonascii.replace(',','').replace('.','').replace('?','').replace('/',' ').replace(':','').replace(';','').replace('<','').replace('>','').replace('[','').replace(']','').replace('\\',' ').replace('"','').replace("'",'').replace('`','')
    _tokens = nltk.word_tokenize(scrubstr)
    tokens = nltk.FreqDist(word.lower() for word in _tokens)
    return tokens

def savewords(tokens,articleid,sourceid,thedate):
    wrds = words()
    for token,frequency in tokens.items():
        if len(token) > 4:
            wrds.add(token,frequency,articleid,sourceid,thedate)

def savearticle(sourceid,title,thedate):
    artcls = articles()
    success = False
    articleid = -1
    if artcls.checkexists(title) == False:
        articleid = artcls.add(sourceid,title,thedate)
        success = True
    return success,articleid

def getlinks(url):
    html = urllib2.urlopen(url)
    soup = BeautifulSoup(html,from_encoding="utf-8")
    tags = soup.find_all('a', href=True)
    links = []
    for tag in tags:
        if len(tag['href']) > 10:
            _id = tag['href'].split('/')[2]
            _articleid =  tag['href'].split('/')[3]
            links.append("article.php?id={0}&articleid={1}".format(_id,_articleid))
    return links

def getarticle(url):
    html = urllib2.urlopen(url)
    soup = BeautifulSoup(html,from_encoding="utf-8")
    titletag = soup.find("h2")
    title = nltk.clean_html("{0}".format(titletag))
    ptags = soup.find_all("p")
    text = nltk.clean_html("{0}".format(ptags[2]))
    return title,text

def main(argv):
    print "Application Started."

    thedate = time.strftime('%Y-%m-%d')
    indexurl = "http://m.whec.com/basic/article.php?id=59103"
    baseurl = "http://m.whec.com/basic/"
    sourceid = 2

    print "Getting links from page ..."

    links = getlinks(indexurl)

    count = 0
    for link in links:
        url = "{0}{1}".format(baseurl,link)
        title,text = getarticle(url)
        words = getwords(text)
        valid,articleid = savearticle(sourceid,title,thedate)
        if valid == True:
            savewords(words,articleid,sourceid,thedate)
            print "Saving '{0}' ...".format(title)
            count += 1
        else:
            print "Ignoring already processed article."
    print "Articles saved: {0}".format(count)

    print "Application Exiting."

if __name__ == '__main__': sys.exit(main(sys.argv))
