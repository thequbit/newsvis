import MySQLdb as mdb
import _mysql as mysql
import re

class sources:

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

    def add(self,name,url):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("INSERT INTO sources(name,url) VALUES(%s,%s)",(self.__sanitize(name),self.__sanitize(url)))
            cur.close()
            newid = cur.lastrowid
        return newid

    def get(self,sourceid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM sources WHERE sourceid = %s",(sourceid))
            row = cur.fetchone()
            cur.close()
        return row

    def getall(self):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("SELECT * FROM sources")
            rows = cur.fetchall()
            cur.close()

        _sources = []
        for row in rows:
            _sources.append(row)

        return _sources

    def delete(self,sourceid):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("DELETE FROM sources WHERE sourceid = %s",(sourceid))
            cur.close()

    def update(self,sourceid,name,url):
        with self.__con:
            cur = self.__con.cursor()
            cur.execute("UPDATE sources SET name = %s,url = %s WHERE sourceid = %s",(self.__sanitize(name),self.__sanitize(url),self.__sanitize(sourceid)))
            cur.close()

##### Application Specific Functions #####
