import Selectors from './selectors';

const registerEventListeners = () => {
    document.addEventListener('click', e => {
        if (e.target.closest(Selectors.actions.showAlertButton)) {
            window.alert("Thank you for clicking on the button");
        }

        if (e.target.closest(Selectors.actions.bigRedButton)) {
            window.alert("You shouldn't have clicked on that one!");
        }
    });
};

export const init = ({stringone, stringtwo}) => {
    window.console.log('Textone: ' + stringone);
    window.console.log('Texttwo: ' + stringtwo);
    registerEventListeners();
};