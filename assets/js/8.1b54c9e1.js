(window.webpackJsonp=window.webpackJsonp||[]).push([[8],{360:function(e,a,t){"use strict";t.r(a);var r=t(43),i=Object(r.a)({},(function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("ContentSlotsDistributor",{attrs:{"slot-key":e.$parent.slotKey}},[t("h1",[e._v("KeyChain")]),e._v(" "),t("h3",{attrs:{id:"set-a-key-pair-for-your-provider"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#set-a-key-pair-for-your-provider"}},[e._v("#")]),e._v(" Set a key pair for your provider")]),e._v(" "),t("p",[e._v("This plugin installs and uses our "),t("a",{attrs:{href:"https://github.com/flipboxfactory/keychain",target:"_blank",rel:"noopener noreferrer"}},[e._v("KeyChain Plugin"),t("OutboundLink")],1),e._v(" to manage your key pairs. It's able to create key pairs using OpenSSL or import your existing key pairs.")]),e._v(" "),t("div",{staticClass:"custom-block tip"},[t("p",{staticClass:"custom-block-title"},[e._v("Recommended")]),e._v(" "),t("p",[e._v("Create a key pair for your provider. SAML protocol may sign and encrypt messages between the Identity Provider (IDP) and the Service Provider (SP). This makes the communication and transmission of the data more secure and any good IDP will support signing and encrypting message data. This requires a key pair.")])]),e._v(" "),t("h4",{attrs:{id:"option-1-generate-key-pair"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#option-1-generate-key-pair"}},[e._v("#")]),e._v(" Option 1: Generate Key Pair")]),e._v(" "),t("p",[e._v('When you are creating your provider, there is an option on the right sidebar to "Generate key pair".')]),e._v(" "),t("p",[e._v("Clicking that button will generate a key pair for you using OpenSSL and some default settings.")]),e._v(" "),t("ul",[t("li",[e._v("Control Panel path reference: "),t("code",[e._v("/admin/saml-sp/metadata/my-provider")]),e._v(".")]),e._v(" "),t("li",[e._v("Navigate (from sidebar): My Provider")])]),e._v(" "),t("h4",{attrs:{id:"option-2-create-a-key-pair-with-openssl"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#option-2-create-a-key-pair-with-openssl"}},[e._v("#")]),e._v(" Option 2: Create a Key Pair with OpenSSL")]),e._v(" "),t("p",[e._v("From the SAML plugin in the Craft admin, go to 'Create a new key pair'. This form contains the same fields you may be familiar with when running the command via the CLI. Use a descriptive name to identify the key pair so you can match it to your provider later.")]),e._v(" "),t("ul",[t("li",[e._v("Control Panel path reference: "),t("code",[e._v("/admin/saml-sp/keychain/new-openssl")]),e._v(".")]),e._v(" "),t("li",[e._v('Navigate (from sidebar): Keychain > Dropdown button in the upper right "Create New OpenSSL Key Pair"')])]),e._v(" "),t("h4",{attrs:{id:"option-3-bring-your-own-key-pair-byok"}},[t("a",{staticClass:"header-anchor",attrs:{href:"#option-3-bring-your-own-key-pair-byok"}},[e._v("#")]),e._v(" Option 3: Bring your Own Key Pair (BYOK)")]),e._v(" "),t("p",[e._v("Generate a key by running the following command in your terminal. Copy the key pairs.")]),e._v(" "),t("div",{staticClass:"language-bash extra-class"},[t("pre",{pre:!0,attrs:{class:"language-bash"}},[t("code",[e._v("openssl req -new -x509 -days "),t("span",{pre:!0,attrs:{class:"token number"}},[e._v("365")]),e._v(" -nodes -sha256 -out saml-sp.crt -keyout saml-sp.pem\n")])])]),t("p",[e._v("From the SAML plugin in the Craft admin, import the key pair at 'Create new key pair'.")]),e._v(" "),t("ul",[t("li",[e._v("Control Panel path reference: "),t("code",[e._v("/admin/saml-sp/keychain/new")]),e._v(".")]),e._v(" "),t("li",[e._v('Navigate (from sidebar): Keychain > Button in the upper right "Add New Key Pair"')])])])}),[],!1,null,null,null);a.default=i.exports}}]);