import MySQLdb as mdb
import _mysql as mysql
import re

class articles:

    __settings = {}
    __con = False

    def __init__(self):
        configfile = "sqlcreds.txt"
        f = open(configfile)
        for line in f:
            # skip comment lines
            m = re.search('^\s*#', line)
            if m:
                continue

            # parse key=value lines
            m = re.search('^(\w+)\s*=\s*(\S.*)$', line)
            if m is None:
                continue

            self.__settings[m.group(1)] = m.group(2)
        f.close()

        # create connection
        self.__con = mdb.connect(host=self.__settings['host'], user=self.__settings['username'], passwd=self.__settings['password'], db=self.__settings['database'])

    def __sanitize(self,valuein):
        if type(valuein) == 'str':
            valueout = mysql.escape_string(valuein)
        else:
            valueout = valuein
        return valuein

    def add(self,sourceid,title,articledate):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("INSERT INTO articles(sourceid,title,articledate) VALUES(%s,%s,%s)",(self.__sanitize(sourceid),self.__sanitize(title),self.__sanitize(articledate)))
            cur.close()
            newid = cur.lastrowid
        return newid

    def get(self,articleid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM articles WHERE articleid = %s",(articleid))
            row = cur.fetchone()
            cur.close()
        return row

    def getall(self):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM articles")
            rows = cur.fetchall()
            cur.close()

        _articles = []
        for row in rows:
            _articles.append(row)

        return _articles

    def delete(self,articleid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("DELETE FROM articles WHERE articleid = %s",(articleid))
            cur.close()

    def update(self,articleid,sourceid,title,articledate):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("UPDATE articles SET sourceid = %s,title = %s,articledate = %s WHERE articleid = %s",(self.__sanitize(sourceid),self.__sanitize(title),self.__sanitize(articledate),self.__sanitize(articleid)))
            cur.close()

##### Application Specific Functions #####

    def checkexists(self,title):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT count(articleid) as count FROM articles WHERE title = %s",(title))
            row = cur.fetchone()
            cur.close()
        _exists = False
        if int(row[0] != 0):
            _exists = True
        return _exists
