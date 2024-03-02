---
Title: Database index out of date error
Author: Tom Jensen
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Database index out of date error
================================

This is a BDE/Paradox error message. For newbies, BDE error messages are
daunting, cryptic messages. Actually, even for seasoned veterans, they
can sometimes be real "stumpers." Unfortunately, there's no real good
reference available that I know of, so all I can offer with respect to
this error message is my experience.

The "Index out of date" message can mean a couple of things:

1.        One of the more common causes of this error is one in which
       you have a couple of copies of a table existing on your network or
       machine. For instance, when I develop applications, I have my
       application tables residing in my development system, then have copies
       of them on my network. When I need to update my tables, I usually do the
       updates in my development system, then copy them over to my deployment
       system on the network. I've run into this exact error when I've copied
       only the table (.DB) file and not its accompanying index file(s) (.PX,
       .X01, .Y01, etc) as well. You see, when you update a table by changing
       it in any way, its index files are also resynched to reflect the
       changes. So if you copy just the table to a new place on your system and
       don't include its family members, you'll index files that aren't in
       synch with your table. Okay that's one cause.

2.        The next cause could be just this: One of your indexes is
       corrupt. This could be due to sector errors on your hard disk, or the
       rare, but possible, direct corruption of an index. This usually happens
       if your program abended while performing an update to a table with an
       index of some sort. In that case, the index doesn't get updated.

But in any case, the only way I know of to correct the problem is to do
the following:

1. Open up your table in Database Desktop.
2. Restructure it.
3. Define/Rebuild all your indexes.
4. Save the file.


------------------------------------------------------------------------

Комментарий:

Некоторое время назад у меня также была масса ошибок типа 'index out of
date' и даже искажение данных. После продолжительного исследования я
выяснил причину, она оказалось в различных установках Paradox Language в
BDE (v1 и V3) на странице Driver и System в утилите конфигурирования
BDE. Я не обратил внимание на установки на странице System одной из
рабочих станций, и получил искажение данных.

Source: <https://delphiworld.narod.ru>
