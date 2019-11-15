(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{206:function(e,t,r){"use strict";r.r(t);var a=r(0),i=Object(a.a)({},(function(){var e=this,t=e.$createElement,r=e._self._c||t;return r("ContentSlotsDistributor",{attrs:{"slot-key":e.$parent.slotKey}},[r("h1",[e._v("Overview")]),e._v(" "),r("p",[e._v("There are two steps to configure the plugin.")]),e._v(" "),r("h3",{attrs:{id:"step-1-create-your-service-provider"}},[r("a",{staticClass:"header-anchor",attrs:{href:"#step-1-create-your-service-provider"}},[e._v("#")]),e._v(" Step 1: Create your Service Provider")]),e._v(" "),r("ul",[r("li",[e._v("Navigation (from the sidebar): My Provider")]),e._v(" "),r("li",[e._v("Control Panel path reference: "),r("code",[e._v("/admin/saml-sp/metadata/my-provider")]),e._v(".")])]),e._v(" "),r("p",[e._v('To create your Service Provider, the sites entity definition, navigate to "My Provider". There you can\ngenerate a key pair for encryption and message signing, as well as, give your provider a label.\nGiving providers a label can be helpful when you have multiple environments. You can name it whatever you\nthink best but something like '),r("code",[e._v("Production")]),e._v(" can be useful.")]),e._v(" "),r("h3",{attrs:{id:"step-2-import-your-identity-provider-s-idp-metadata"}},[r("a",{staticClass:"header-anchor",attrs:{href:"#step-2-import-your-identity-provider-s-idp-metadata"}},[e._v("#")]),e._v(" Step 2: Import your Identity Provider's (IDP) metadata")]),e._v(" "),r("ul",[r("li",[e._v('Navigation (from the sidebar): Provider List > click the "+ Add Identity Provider" button')]),e._v(" "),r("li",[e._v("Control Panel path reference: "),r("code",[e._v("/admin/saml-sp/metadata/new-idp")]),e._v(".")])]),e._v(" "),r("p",[e._v('Retrieve your IDP\'s metadata and import it into Craft. The IDP metadata can be difficult to find but they do give access to this information.\nThe metadata has everything needed to communicate with the remote provider. Copy the contents of the metadata xml,\nnavigate to "+Add Identity Provider", and paste it into the metadata field. Label the IDP with a descriptor of the provider.\nFor example, if the IDP is ADFS it can be labeled as such: '),r("code",[e._v("ADFS")]),e._v('. From this view, you can click the "Configure" tab where\nyou can map attributes from the IDP response to the Craft user property.')])])}),[],!1,null,null,null);t.default=i.exports}}]);