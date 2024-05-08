function moveObject(sourceListId, destinationSourceId) {
    let sourceList = $('#'+sourceListId);
    let destinationList = $('#'+destinationSourceId);

    // Check if there's any selected option
    if (sourceList.find('option:selected').length === 0) return; // No selection made, exit function

    let selectedOption = sourceList.find('option:selected').first(); // Get the first selected option

    // Create a new option element for the destination list
    let newOption = $('<option>', {
        text: selectedOption.text(),
        value: selectedOption.val()
    });

    // Add the new option to the destination list
    destinationList.append(newOption);

    // Remove the selected option from the source list
    selectedOption.remove();
}
