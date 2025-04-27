(function () {
  document.addEventListener(
    "click",
    function (event) {
      let target = event.target;
      console.log(
        "%cSelected Element:",
        "color: blue; font-weight: bold;",
        target
      );

      // Start observing changes to the selected element
      let observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
          if (
            mutation.type === "attributes" ||
            mutation.type === "childList" ||
            mutation.type === "characterData"
          ) {
            console.log(
              "%cElement Modified:",
              "color: red; font-weight: bold;",
              target
            );

            // Capture the call stack to see which script executed the change
            console.trace("Modification Source:");

            // Get all scripts in the document
            let scripts = document.querySelectorAll("script");
            let modifyingScripts = [];

            scripts.forEach((script) => {
              let src = script.getAttribute("src") || "(Inline Script)";
              let handle =
                script.getAttribute("script-handle") || "(Unknown Handle)";

              // Check if the script has run recently (approximation)
              performance.getEntriesByType("resource").forEach((entry) => {
                if (entry.name.includes(src)) {
                  modifyingScripts.push({ handle, src });
                }
              });
            });

            console.log(
              "%cPotential Responsible Scripts:",
              "color: orange; font-weight: bold;",
              modifyingScripts
            );
          }
        });
      });

      observer.observe(target, {
        attributes: true,
        childList: true,
        subtree: true,
        characterData: true,
      });

      setTimeout(() => observer.disconnect(), 5000); // Stop observing after 5 seconds
    },
    true
  );
})();
