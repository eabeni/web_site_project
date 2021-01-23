#!/home/edoardo/anaconda3/bin/python
import sys
# get sys package for file arguments etc
import pymysql
import numpy as np
import scipy.stats as sp
import matplotlib.pyplot as plt
from numpy.polynomial.polynomial import polyfit
import io
con = pymysql.connect(host='localhost', user='pippo', passwd='+Mary1918%mario', db='university_uni')
cur = con.cursor()
if(len(sys.argv) != 4) :
  print ("Usage: correlate.py col1 col2 (selection); Nparams = ",sys.argv)
  sys.exit(-1)

col1 = sys.argv[1]
col2 = sys.argv[2]
sel  = sys.argv[3]
sql = "SELECT %s,%s FROM Compounds where %s" % (col1,col2,sel)
cur.execute(sql)
nrows = cur.rowcount
ds = cur.fetchall()
ads = np.array(ds)
#print ("correlation is", sp.pearsonr(ads[:,0],ads[:,1])," over ",nrows,"data")

# Sample data
x = ads[:,0]
y = ads[:,1]

# Fit with polyfit
b, m = polyfit(x, y, 1)

plt.plot(x, y, '.')
plt.plot(x, b + m * x, '-')
plt.xlabel(col1)
plt.ylabel(col2)
image = io.BytesIO()
plt.savefig(image,format='png')
sys.stdout.buffer.write(image.getvalue())
#plt.show()
con.close()
