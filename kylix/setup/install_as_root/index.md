---
Title: Should I install Kylix as root or a regular user?
Date: 01.01.2007
---


Should I install Kylix as root or a regular user?
=================================================

Installing Kylix as root has the advantage of allowing all users to
access the Kylix installation, provided you install it into a "shared"
location. I reccomend installing Kylix as root into the directory
/usr/local/kylix. However, if you are going to be the only user using
Kylix, you may want to install it as that user into your home directory.

To install as root, type `su` from the command prompt and enter the super
user password. Then, run the Kylix installer.

---
**Примечание от Vit**

Обычно при установке от имени root возникает ошибка -10
