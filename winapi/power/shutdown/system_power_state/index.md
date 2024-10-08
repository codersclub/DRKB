---
Title: Приостановить ПК
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Приостановить ПК
================

Функция **SetSystemPowerState** приостанавливает работу системы путем отключения питания.
В зависимости от параметра `ForceFlag` функция либо немедленно приостанавливает работу,
либо перед этим запрашивает разрешение на завершение у всех приложений и драйверов устройств.

```delphi
    BOOL SetSystemPowerState(
       BOOL fSuspend,      
       BOOL fForce      
    );      
```

**Параметры:**

fSuspend
: Техника приостановки. Если TRUE, система приостанавливает работу с использованием метода RAM-alive.
В противном случае происходит приостановка с использованием метода гибернации.

fForce
: Принудительная приостановка.
Если TRUE, функция отправляет сообщение PBT_APMSUSPEND каждому приложению и драйверу,
а затем немедленно приостанавливает работу.
Если значение FALSE, функция отправляет сообщение PBT_APMQUERYSUSPEND каждому приложению,
чтобы запросить разрешение на приостановку операции.

**Возвращаемые значения:**

Если питание было приостановлено, а затем восстановлено, возвращаемое значение не равно нулю.

Если система не была приостановлена, возвращаемое значение равно нулю.
Чтобы получить расширенную информацию об ошибке, вызовите `GetLastError`.

**Примечание:**

Если какое-либо приложение или драйвер отказывает в разрешении на приостановку работы,
функция отправляет сообщение `PBT_APMQUERYSUSPENDFAILED` каждому приложению и драйверу.
Если питание приостановлено, эта функция возвращается только после возобновления работы системы
и отправки соответствующих сообщений `WM_POWERBROADCAST` всем приложениям и драйверам.

**Примеры вызова:**

```delphi
    SetSystemPowerState(False, True); //Forces the system down
    SetSystemPowerState(True, False); //Makes a "soft" off
```

