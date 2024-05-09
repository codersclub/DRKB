---
Title: Error «permission denied» when trying to run Kylix
Date: 01.01.2007
---


Error «permission denied» when trying to run Kylix
==================================================

If you installed as root and accepted the defaults then Kylix was
installed under the /root directory. By default the permissions for this
directory are 700 so only the root user can access this directory tree
for read, write or execute. If users besides root are to use Kylix it
must be installed in a directory all will have access to. See the file
INSTALL that comes with Kylix for more information.
