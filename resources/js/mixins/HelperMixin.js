import md5 from "md5";
import numeral from "numeral";

export default {
  computed: {
    CurrentTenant() {
      return window.CurrentTenant;
    },

    isAdmin() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Admin");
    },

    isUser() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("User");
    },

    isWriter() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Writer");
    },

    isEditor() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Editor");
    },

    isDataEntry() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Data Curator");
    },

    isDataEditor() {
      return this.CurrentTenant.user && this.CurrentTenant.user.roles.includes("Data Researcher & Editor");
    },

    isAdminPage() {
      let patt = new RegExp("/admin");
      return patt.test(this.$route.path);
    },

    isLoggedIn() {
      return this.CurrentTenant.user && this.CurrentTenant.user.name
    }
  },

  methods: {
    slugify(text) {
      return text
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "-")
        .replace(/[^\w\-]+/g, "")
        .replace(/--+/g, "-");
    },

    makeVariable(text) {
      return text
        .toString()
        .toLowerCase()
        .replace(/\s+/g, "_")
        .replace(/[^\w\-]+/g, "")
        .replace(/--+/g, "_");
    },

    suffixedNumber(number) {
      if (number < 900) {
        return number;
      } else {
        return numeral(number).format("0.0a");
      }
    },

    trim(string, length = 70) {
      return _.truncate(string, {
        length: length
      });
    },

    defaultGravatar(email, size = 200) {
      let hash = md5(email.trim().toLowerCase());

      return "https://secure.gravatar.com/avatar/" + hash + "?s=" + size;
    },

    mediaUploadPath() {
      return "/api/v1/media/uploads";
    },

    resourceUploadPath() {
      return "/api/v1/resource/uploads"
    },

    hasPermission(permission) {
      return CurrentTenant.user.permissions.includes(permission);
    },

    hasSubapp(subapp) {
      return CurrentTenant.subapps.includes(subapp);
    },
    
    downloadBlob(blob, filename) {
      alert(typeof blog)
      // Create an object URL for the blob object
      // const url = URL.createObjectURL(blob);
      
      // Create a new anchor element
      const a = document.createElement('a');
      
      // Set the href and download attributes for the anchor element
      // You can optionally set other attributes like `title`, etc
      // Especially, if the anchor element will be attached to the DOM
      a.href = blob;
      a.download = filename || 'download';
      
      // Click handler that releases the object URL after the element has been clicked
      // This is required for one-off downloads of the blob content
      const clickHandler = () => {
        setTimeout(() => {
          URL.revokeObjectURL(url);
          this.removeEventListener('click', clickHandler);
        }, 150);
      };
      
      // Add the click event listener on the anchor element
      // Comment out this line if you don't want a one-off download of the blob content
      a.addEventListener('click', clickHandler, false);
      
      // Programmatically trigger a click on the anchor element
      // Useful if you want the download to happen automatically
      // Without attaching the anchor element to the DOM
      // Comment out this line if you don't want an automatic download of the blob content
      a.click();
      
      // Return the anchor element
      // Useful if you want a reference to the element
      // in order to attach it to the DOM or use it in some other way
      return a;
    },

    prettyJSON: function (json) {
      if (json) {
        json = JSON.stringify(json, undefined, 4);
        json = json.replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
          var cls = 'number';
          if (/^"/.test(match)) {
            if (/:$/.test(match)) {
              cls = 'key';
            } else {
              cls = 'string';
            }
          } else if (/true|false/.test(match)) {
            cls = 'boolean';
          } else if (/null/.test(match)) {
            cls = 'null';
          }
          return '<span class="' + cls + '">' + match + '</span>';
        });
      }
    }
  },
};
