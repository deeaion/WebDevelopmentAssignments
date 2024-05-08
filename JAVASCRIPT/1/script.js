function moveObject(sourceListId, destinationSourceId) {
    let sourceList = document.getElementById(sourceListId);
    let destinationList = document.getElementById(destinationSourceId);

    // Check if there's any selected option
    if (sourceList.selectedOptions.length === 0) return; // No selection made, exit function

    let selectedOption = sourceList.selectedOptions[0]; // Get the first selected option

    // Create a new option element for the destination list
    let newOption = new Option(selectedOption.text, selectedOption.value);

    // Add the new option to the destination list
    destinationList.add(newOption);

    // Remove the selected option from the source list
    sourceList.remove(selectedOption.index); // Use index of the selected option for removal
}
