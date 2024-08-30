---
Title: Определение наличия функции в DLL
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Определение наличия функции в DLL
=========================

Данная функция определяет присутствие нужной функции в библиотеке (dll)
и, в случае нахождения искомой функции, возвращает True, иначе False.

    function FuncAvail (VLibraryname, VFunctionname: string; var VPointer: pointer): 
    boolean; 
    var 
      Vlib: tHandle; 
    begin 
      Result := false; 
      VPointer := NIL; 
       if LoadLibrary(PChar(VLibraryname)) = 0 then 
          exit; 
       VPointer := GetModuleHandle(PChar(VLibraryname)); 
       if Vlib <> 0 then 
       begin 
        VPointer := GetProcAddress(Vlib, PChar(VFunctionname)); 
        if VPointer <> NIL then 
           Result := true; 
       end; 
    end; 

