---
Title: Как проиграть wav из ресурса не сохраняя его в файл?
Date: 01.01.2007
Source: Delphi Knowledge Base: <https://www.baltsoft.com/>
---


Как проиграть wav из ресурса не сохраняя его в файл?
====================================================

    { ... }
    var
      FindHandle, ResHandle: THandle;
      ResPtr: Pointer;
    begin
      FindHandle := FindResource(HInstance, 'Name of your resource', 'WAVE');
      if FindHandle <> 0 then
      begin
        ResHandle := LoadResource(HInstance, FindHandle);
        if ResHandle <> 0 then
        begin
          ResPtr := LockResource(ResHandle);
          if ResPtr <> nil then
            SndPlaySound(PChar(ResPtr), snd_ASync or snd_Memory);
          UnlockResource(ResHandle);
        end;
        FreeResource(FindHandle);
      end;
    end;

