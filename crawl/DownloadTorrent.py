#!/usr/bin/env python2.7
#coding: utf8
'''
获取种子信息并保存入数据库函数
author: BaCde[Insight Labs]
email:glacier@insight-labs.org
'''


import cPickle
import hashlib
import time
import traceback
import datetime
import sys
import bencode
import cStringIO
import gzip
import urllib2
import binascii
import socket
import threading
import Queue
import xmlrpclib
import metautils
import libtorrent as lt
import random
import json
import threading
import MySQLdb as mdb
import requests
import urlparse

#threading.stack_size(128000)
socket.setdefaulttimeout(10)
MAX_READ = 30
DB_HOST = '127.0.0.1'
DB_USER = 'root'
DB_PASS = '12345'
q = Queue.Queue(MAX_READ)
downloading = set()

dicpath = "movie_hash.txt"

s = '%d\t%d\t%s\n'
headers = {
    "Connection": "keep-alive",
    "Accept":"text/html,application/xhtml+xml,\
        application/xml;q=0.9,image/webp,*/*;q=0.8",
    "Accept-Encoding":"gzip,deflate,sdch",
    "Accept-Language":"en-US,en;q=0.8,zh-CN;\
        q=0.6,zh;q=0.4,zh-TW;q=0.2",
    "User-Agent":"Mozilla/5.0 (X11; Linux x86_64) \
        AppleWebKit/537.36 (KHTML, like Gecko) \
        Chrome/40.0.2214.91 Safari/537.36"
}

ss = requests.session()
ss.headers.update(headers)

def save_img(url, ext):
    path = os.path.join(os.path.expanduser('~'), 'vcode.%s' % ext)
    with open(path, 'w') as g:
        data = requests.get(url).content
        g.write(data)
    #print "  ++ 验证码已保存至", s % (1, 97, path)
    input_code = raw_input(" captach: ")
    return input_code

def do(url):
    try:
        r = ss.get(url, timeout=20)
        cnt = r.content
        if r.ok and cnt and '<head>' not in cnt \
            and '4:name' in cnt:
            print s % (1, 92, '  √ get torrent.')
            return cnt
        else:
            print s % (1, 91, '  × not get.')
            return None
    except:
        return None

class DHTReporter(threading.Thread):
    def __init__(self):
        threading.Thread.__init__(self)
        self.setDaemon(True)
        self.ses = lt.session()
        self.init_libtorrent()
        self.dbconn = mdb.connect(DB_HOST, DB_USER, DB_PASS, 'dht', charset='utf8')
        self.dbcurr = self.dbconn.cursor()
        self.dbcurr.execute('SET NAMES utf8')
        self.url = 'http://torcache.net/torrent/%s.torrent'

    def init_libtorrent(self):
        ses = self.ses
        r = random.randrange(10000, 50000)
        ses.listen_on(r, r+10)
        ses.add_dht_router('router.bittorrent.com',6881)
        ses.add_dht_router('router.utorrent.com',6881)
        ses.add_dht_router('dht.transmission.com',6881)
        ses.add_dht_router('70.39.87.34',6881)
        ses.start_dht()


    def get_torrent(self,hh):
        if hh in downloading:
            return None
        downloading.add(hh)
        name = hh.upper()
        #print s % (1, 93, '\n  ++ get torrent from web')
        ## xunlei
        '''
        print s % (1, 94, '  >> try:'), 'bt.box.n0808.com'
        url = 'http://bt.box.n0808.com/%s/%s/%s.torrent' \
            % (hh[:2], hh[-2:], hh)
        ss.headers['Referer'] = 'http://bt.box.n0808.com'
        result = do(url)
        if result: return result

        ## https://torrage.com
        if ss.headers.get('Referer'): del ss.headers['Referer']
        print s % (1, 94, '  >> try:'), 'torrage.com'
        url = 'http://torrage.com/torrent/%s.torrent' % hh
        try:
            result = do(url)
            if result: return result
        except:
            pass
        '''
        '''
        ## http://btcache.me
        if ss.headers.get('Referer'): del ss.headers['Referer']
        #print s % (1, 94, '  >> try:'), 'btcache.me'
        url = 'http://btcache.me/torrent/%s' % hh
        r = ss.get(url)
        key = re.search(r'name="key" value="(.+?)"', r.content)
        if key:
            url = 'http://btcache.me/captcha'
            vcode = save_img(url, 'png')
            data = {
                "key": key.group(1),
                "captcha": vcode
            }
            ss.headers['Referer'] = url
            url = 'http://btcache.me/download'
            result = do(url)
            if result: return result
        #else:
        #    print s % (1, 91, '  × not get.')
        '''

        ## torrent stores
        if ss.headers.get('Referer'): del ss.headers['Referer']
        '''
        urls = [
                #'http://www.sobt.org/Tool/downbt?info=%s',
                #'http://www.win8down.com/url.php?hash=%s&name=name',
                #'http://www.31bt.com/Torrent/%s',
                #'http://178.73.198.210/torrent/%s',
                #'http://zoink.it/torrent/%s.torrent',
                'http://torcache.net/torrent/%s.torrent',
                #'http://torrentproject.se/torrent/%s.torrent',
                #'http://istoretor.com/fdown.php?hash=%s',
                #'http://torrentbox.sx/torrent/%s',
                #'http://www.torrenthound.com/torrent/%s',
                #'http://www.silvertorrent.org/download.php?id=%s',
        ]
        '''
        dourl = self.url % name
        #for url in urls:
            #print s % (1, 94, '  >> try:'), urlparse.urlparse(url).hostname
        #    url = url % name
        try:
            result = do(dourl)
            downloading.remove(hh)
            #self.ses.remove_torrent(handle)
            if result: return result
        except:
        #    print s % (1, 91, '  !! Error at connection')
            downloading.remove(hh)
            print 'Error at connection'
        print dourl + '  :' + self.getName()

    def fetch_torrent(self, ih):
        if ih in downloading:
            return None
        downloading.add(ih)
        name = ih.upper()
        url = 'magnet:?xt=urn:btih:%s' % (name,)
        data = ''
        params = {
            'save_path': '/tmp/downloads/',
            'storage_mode': lt.storage_mode_t(2),
            'paused': False,
            'auto_managed': False,
            'duplicate_is_error': True}
        try:
            handle = lt.add_magnet_uri(self.ses, url, params)
        except:
            downloading.remove(ih)
            return None
        status = self.ses.status()
        #print 'downloading metadata:', url
        handle.set_sequential_download(1)
        down_time = time.time()
        for i in xrange(0, 60):
            if handle.has_metadata():
                info = handle.get_torrent_info()
                print '\n', time.ctime(), (time.time()-down_time), 's, got', url, info.name()
                meta = info.metadata()
                self.ses.remove_torrent(handle)
                downloading.remove(ih)
                return meta
            time.sleep(1)
        downloading.remove(ih)
        self.ses.remove_torrent(handle)
        return None

    def decode(self, s):
        if type(s) is list:
            print 'list', s
            s = ';'.join(s)
        u = s
        for x in (self.encoding, 'utf8', 'gbk', 'big5'):
            try:
                u = s.decode(x)
                return u
            except:
                pass
        return s.decode(self.encoding, 'ignore')

    def decode_utf8(self, d, i):
        if i+'.utf-8' in d:
            return d[i+'.utf-8'].decode('utf8')
        return self.decode(d[i])

    def parse_meta(self, meta):
        info = {}
        info['create_time'] = meta.creation_time()
        info['creator'] = meta.creator()
        info['comment'] = meta.comment()
        info['name'] = meta.name()
        info['files'] = []

                
    def parse_torrent(self, data):
        info = {}
        self.encoding = 'utf8'
        torrent = bencode.bdecode(data)
        try:
            info['create_time'] = datetime.datetime.fromtimestamp(float(torrent['creation date']))
        except:
            info['create_time'] = datetime.datetime.utcnow()

        if torrent.get('encoding'):
            self.encoding = torrent['encoding']
        if torrent.get('announce'):
            info['announce'] = self.decode_utf8(torrent, 'announce')
        if torrent.get('comment'):
            info['comment'] = self.decode_utf8(torrent, 'comment')
        if torrent.get('publisher-url'):
            self.encoding = self.decode_utf8(torrent, 'publisher-url')
        if torrent.get('publisher'):
            info['publisher'] = self.decode_utf8(torrent, 'publisher')
        if torrent.get('created by'):
            info['creator'] = self.decode_utf8(torrent, 'created by')

        if 'info' in torrent:
            detail = torrent['info'] 
        else:
            detail = torrent
        #print(detail)
        info['name'] = self.decode_utf8(detail, 'name')
        if 'files' in detail:
            info['files'] = []
            for x in detail['files']:
                if 'path.utf-8' in x:
                    v = {'path': self.decode('/'.join(x['path.utf-8'])), 'length': x['length']}
                else:
                    v = {'path': self.decode('/'.join(x['path'])), 'length': x['length']}
                if 'filehash' in x:
                    v['filehash'] = binascii.hexlify(x['filehash'])
                info['files'].append(v)
            info['length'] = sum([x['length'] for x in info['files']])
        else:
            info['length'] = detail['length']
        info['data_hash'] = hashlib.md5(detail['pieces']).hexdigest()
        if 'profiles' in detail:
            info['profiles'] = detail['profiles']
        return info

    def run(self):
        self.name = threading.currentThread().getName()
        print self.name, 'started'
        n_reqs = n_valid = n_new = 0
        while True:
            x = q.get()
            print 'get + ' + x + '  :' + self.getName() +'\n'
            n_reqs += 1

            utcnow = datetime.datetime.utcnow()
            date = (utcnow + datetime.timedelta(hours=8))
            date = datetime.datetime(date.year, date.month, date.day)
            while True:
                # Check if we have this info_hash
                self.dbcurr.execute('SELECT id FROM movie_hash WHERE hash=%s', (x))
                y = self.dbcurr.fetchone()
                if not y:
                    try:
                        data = self.get_torrent(x)
                    except:
                        traceback.print_exc()
                        break
                    if not data:
                        sys.stdout.write('!')
                        break
                    try:
                        info = self.parse_torrent(data)
                    except:
                        traceback.print_exc()
                        break
                    info['info_hash'] = x
                    info['reqtimes'] = 1
                    info['updatetime'] = utcnow
                    info['source'] = '127.0.0.1'
                    info['create_time'] = utcnow

                    if info.get('files'):
                        files = [z for z in info['files'] if not z['path'].startswith('_')]
                        if not files:
                            files = info['files']
                    else:
                        files = [{'path': info['name'], 'length': info['length']}]
                    files.sort(key=lambda z:z['length'], reverse=True)
                    bigfname = files[0]['path']
                    info['extension'] = metautils.get_extension(bigfname).lower()
                    info['category'] = metautils.get_category(info['extension'])
                    
                    try:
                        if 'files' in info:
                            self.dbcurr.execute('INSERT INTO filelists VALUES(%s, %s)', (info['info_hash'], json.dumps(info['files'])))
                            del info['files']
                    except:
                        traceback.print_exc()
                    try:
                        ret = self.dbcurr.execute('INSERT INTO movie_hash(hash,category,name,source,filesize,createtime,updatetime,reqtimes) VALUES(%s,%s,%s,%s,%s,%s,%s,%s)',
                            (info['info_hash'], info['category'], info['name'], info['source'], 
                            info['length'], info['create_time'], info['updatetime'], info['reqtimes']))
                    except:
                        traceback.print_exc()
                        break
                    n_new += 1
                n_valid += 1

                sys.stdout.write('#')
                sys.stdout.flush()
                self.dbconn.commit()
                break

            if n_reqs >= MAX_READ:
                self.dbcurr.execute('INSERT INTO statusreport(date,new_hashs,total_requests, valid_requests)  VALUES(%s,%s,%s,%s) ON DUPLICATE KEY UPDATE ' +
                    'total_requests=total_requests+%s, valid_requests=valid_requests+%s, new_hashs=new_hashs+%s',
                    (date, n_new, n_reqs, n_valid, n_reqs, n_valid, n_new))
                    
                n_reqs = n_valid = n_new = 0

def load_queue_from_rpc():
    with open(dicpath) as f:
        for line in f:
            try:
                pw = line.strip()
                q.put(pw)
            except KeyboardInterrupt:
               break
            except:
                print sys.exc_info()[1]
                time.sleep(1)
    f.close()

def load_queue_from_rpc2():
    rpc = xmlrpclib.ServerProxy('http://106.185.29.176:8803')  #注意修改这里的信息
    while True:
        try:
            t = rpc.get_req()
            #print t
            q.put(t)
        except KeyboardInterrupt:
            break
        except Exception,ex:
            print ex
            #print sys.exc_info()[1]
            time.sleep(1)

if __name__ == '__main__':
    for x in xrange(MAX_READ):
        reporter = DHTReporter()
        reporter.start()
    load_queue_from_rpc2()

