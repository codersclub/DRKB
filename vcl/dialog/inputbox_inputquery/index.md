---
Title: Использование InputBox и InputQuery
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Использование InputBox и InputQuery
===================================

Данная функция демонстрирует 3 очень мощных и полезных процедуры,
интегрированных в Delphi.

Диалоговые окна InputBox и InputQuery позволяют пользователю вводить
данные.

Функция InputBox используется в том случае, когда не имеет значения, что именно
пользователь выбирает для закрытия диалогового окна - кнопку OK или
кнопку Cancel (или нажатие клавиши Esc). Если вам необходимо знать, какую
кнопку нажал пользователь (OK или Cancel или клавишу Esc),
используйте функцию InputQuery.

ShowMessage - другой простой путь отображения сообщения для
пользователя.

    procedure TForm1.Button1Click(Sender: TObject);
    var
      s, s1: string;
      b: boolean;
    begin
      s := Trim(InputBox('Новый пароль', 'Пароль', 'masterkey'));
      b := s <> '';
      s1 := s;
      if b then
        b := InputQuery('Повторите пароль', 'Пароль', s1);
      if not b or (s1 <> s) then
        ShowMessage('Пароль неверен');
    end;

