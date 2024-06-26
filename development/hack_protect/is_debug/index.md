---
Title: Как определить, находится ли ваше приложение в режиме отладки?
Author: Simon Carter
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как определить, находится ли ваше приложение в режиме отладки?
==============================================================

Обычно господа взломщики, для того, чтобы взломать защиту приложения,
запускают его в режиме отладки и анализируют машинный код для
определения точки перехвата ввода пароля с клавиатуры.

Обычно таким способом ломаются игрушки :)

Конечно данный способ не сможет полностью защитить Ваш программный
продукт от взлома, но прекратить выполнение секретного кода - запросто.
Для этого мы будем использовать API функцию IsDebuggerPresent.
Единственный недостаток этой функции, заключается в том, что она не
работет под Windows 95.

Теперь посмотрим как эту функцию реализовать в Delphi:

    function DebuggerPresent: boolean; 
    type 
      TDebugProc = function: boolean; stdcall; 
    var 
      Kernel32: HMODULE; 
      DebugProc: TDebugProc; 
    begin 
      Result := False; 
      Kernel32 := GetModuleHandle('kernel32.dll'); 
      if Kernel32 <> 0 then 
      begin 
        @DebugProc := GetProcAddress(Kernel32, 'IsDebuggerPresent'); 
        if Assigned(DebugProc) then 
          Result := DebugProc; 
      end; 
    end; 

А это окончательный пример вызова нашей функции:

    if DebuggerPresent then 
      ShowMessage('debugging') 
    else 
      ShowMessage('NOT debugging'); 

