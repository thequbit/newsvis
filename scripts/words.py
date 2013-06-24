import MySQLdb as mdb
import _mysql as mysql
import re

class words:

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

    def add(self,word,frequency,articleid,sourceid,worddate):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("INSERT INTO words(word,frequency,articleid,sourceid,worddate) VALUES(%s,%s,%s,%s,%s)",(self.__sanitize(word),self.__sanitize(frequency),self.__sanitize(articleid),self.__sanitize(sourceid),self.__sanitize(worddate)))
            cur.close()
            newid = cur.lastrowid
        return newid

    def get(self,wordid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM words WHERE wordid = %s",(wordid))
            row = cur.fetchone()
            cur.close()
        return row

    def getall(self):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM words")
            rows = cur.fetchall()
            cur.close()

        _words = []
        for row in rows:
            _words.append(row)

        return _words

    def delete(self,wordid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("DELETE FROM words WHERE wordid = %s",(wordid))
            cur.close()

    def update(self,wordid,word,frequency,articleid,sourceid,worddate):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("UPDATE words SET word = %s,frequency = %s,articleid = %s,sourceid = %s,worddate = %s WHERE wordid = %s",(self.__sanitize(word),self.__sanitize(frequency),self.__sanitize(articleid),self.__sanitize(sourceid),self.__sanitize(worddate),self.__sanitize(wordid)))
            cur.close()

##### Application Specific Functions #####
