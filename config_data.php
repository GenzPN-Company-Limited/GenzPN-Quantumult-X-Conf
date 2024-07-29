<?php

function getConfigData($url) {
    return <<<EOD
[general]
profile_img_url=https://avatars.githubusercontent.com/u/39546317
resource_parser_url=https://raw.githubusercontent.com/KOP-XIAO/QuantumultX/master/Scripts/resource-parser.js
server_check_url=http://www.google.com/generate_204
udp_whitelist=53, 1024-65535
udp_drop_list=443

[dns]
no-ipv6
no-system
server=8.8.8.8
server=1.1.1.1

[policy]
url-latency-benchmark=Tự chọn, server-tag-regex=.*, check-interval=600, tolerance=0, alive-checking=false, img-url=arrow.triangle.merge.system
static=Wifi, Trực tiếp, VPN, Tự chọn, img-url=wifi.system
static=4G, Trực tiếp, VPN, Tự chọn, img-url=cellularbars.system
static=Chặn LKTEAM, BẬT, TẮT, img-url=bookmark.slash.fill.system
static=Trực tiếp, direct, img-url=network.system
static=VPN, proxy, img-url=network.badge.shield.half.filled.system
static=BẬT, reject, img-url=power.circle.fill.system
static=TẮT, direct, img-url=power.circle.system
ssid=End, 4G, Wifi, img-url=power.circle.system

[server_remote]
{$url}, tag=GenzPN Services, img-url=xserve.system, update-interval=172800, opt-parser=true, enabled=true
https://raw.githubusercontent.com/GenzPN-Company-Limited/GenzPN-Proxy/main/Quantumult_X/snippet/002.snippet, tag=Có gì hot?, img-url=list.triangle.system, update-interval=172800, opt-parser=false, enabled=true
https://raw.githubusercontent.com/GenzPN-Company-Limited/GenzPN-Proxy/main/Quantumult_X/snippet/001.snippet, tag=[Luôn bật VPN khi sử dụng], img-url=list.triangle.system, update-interval=172800, opt-parser=false, enabled=true

[filter_remote]
https://raw.githubusercontent.com/bigdargon/hostsVN/master/option/hostsVN-quantumult-exceptions-rule.conf, tag=🇻🇳hostsVN, force-policy=direct, update-interval=172800, opt-parser=true, enabled=true
https://raw.githubusercontent.com/bigdargon/hostsVN/master/option/hostsVN-quantumult-rule.conf, tag=🇻🇳hostsVN, force-policy=reject, update-interval=172800, opt-parser=true, enabled=true
https://raw.githubusercontent.com/bigdargon/hostsVN/master/extensions/threat/quantumult-rule.conf, tag=🇻🇳hostsVN-Threat, force-policy=reject, update-interval=172800, opt-parser=true, enabled=true
https://raw.githubusercontent.com/GenzPN-Company-Limited/GenzPN-Proxy/main/Quantumult_X/filter/GenzPN-quantumult-LKTEAM.conf, tag=LKTEAM, force-policy=Chặn LKTEAM, enabled=true

[rewrite_remote]
https://raw.githubusercontent.com/GenzPN-Company-Limited/GenzPN-Proxy/main/sgmoudule/YouTube.Enhance.sgmodule, tag=Youtube Premium, update-interval=172800, opt-parser=true, enabled=true
https://raw.githubusercontent.com/bigdargon/hostsVN/master/option/hostsVN-quantumultX-rewrite.conf, tag=🇻🇳hostsVN, update-interval=172800, opt-parser=true, enabled=true
https://raw.githubusercontent.com/GenzPN-Company-Limited/GenzPN-Proxy/main/Quantumult_X/picsart.conf, tag=Picsart, enabled=true
https://raw.githubusercontent.com/GenzPN-Company-Limited/GenzPN-Proxy/main/Quantumult_X/truecaller.conf, tag=TrueCaller, enabled=true

[server_local]

[filter_local]
IP-CIDR, 0.0.0.0/32,REJECT,no-resolve
ip-cidr, 127.0.0.0/8, direct
ip-cidr, 192.168.0.0/16, direct
;geoip, vn, direct
final, End

[rewrite_local]

[task_local]
# > GeoIP 查询
event-interaction https://raw.githubusercontent.com/GenzPN-Company-Limited/GenzPN-Proxy/main/Quantumult_X/Scripts/geo_location.js, tag=GeoIP, img-url=location.fill.viewfinder.system

[mitm]
skip_validating_cert = true
passphrase = 9B7A92FD
p12 = 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
EOD;
}
?>