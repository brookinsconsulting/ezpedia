<?php /*

# NuSOAP services configuration file

[GeneralSettings]
# available NuSOAP services
# each service will get his own settings group
# example: the settings group name for a service called myservice is Service_myservice
AvailableServices[]
AvailableServices[]=helloworld
AvailableServices[]=bcsoapsearch
# enable or disable NuSOAP server
EnableSOAP=true
# enable or disable NuSOAP server logging
EnableLog=true
SOAPExtensions[bcsoapsearch]=bcsoapsearch

AvailableServices[]=bcsoapsearch

[Service_bcsoapsearch]
# name of the service
ServiceName=BcSoapSearch
# namespace of the service
ServiceNamespace=urn:bcsoapsearch

*/ ?>
