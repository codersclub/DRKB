---
Title: В основном help-е в Delphi не работает индекс по Win32
Date: 01.01.2007
Source: <https://blackman.wp-club.net/>
---


В основном help-е в Delphi не работает индекс по Win32
=======================================================

Нужно сделать следующее:

- в /help/delphi3.cfg добавить строку типа

        :index Win32=Win32.hlp

  она должна быть добавлена перед строкой

        :Link win32.hlp

- стереть delphi3.gid

- запустить Help и получать удовольствие

- В delphi3.cnt тоже нужно строчку добавить:

        :include win32.cnt

