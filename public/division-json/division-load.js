

window.addEventListener('load', function(){
    getDivision();
})

function getDivision(){
    fetch('./division-json/postcodes.json')
    .then(response => {
        return response.json();
    }).then(data => {
        const divisionArray = [];
        for(let i=0; i < data.postcodes.length; i++){
            let divisionName = data.postcodes[i]['division'];
            if(!divisionArray.includes(divisionName)){
                divisionArray.push(divisionName)
            }
        }

        const divisionElement = document.querySelector('#division');
        divisionArray.forEach(element => {
            let option = document.createElement('option');
            option.value = element;
            option.innerHTML = element;
            divisionElement.appendChild(option);
        })

        console.log(divisionArray)
    
    })
}

const divisionElement = document.querySelector('#division');
divisionElement.addEventListener('change', function(){

    if(!this.value){
        clearOptions('district');
        clearOptions('thana');
        return false;
    }  

    fetch('./division-json/postcodes.json')
    .then(response => {
        return response.json();
    }).then(data => {
        const districtArray = [];
        for(let i=0; i < data.postcodes.length; i++){
            const districtName = data.postcodes[i]['district'];
            const divisionName = data.postcodes[i]['division'];
            if(divisionName === this.value){
                if(!districtArray.includes(districtName)){
                    districtArray.push(districtName)
                }
            }
        }

        const districtElement = document.querySelector('#district');
        clearOptions('district')
        districtArray.forEach(element => {
            const option = document.createElement('option');
            option.value = element;
            option.innerHTML = element;
            districtElement.appendChild(option);
        })
    })
});

const districtElement = document.querySelector('#district');
districtElement.addEventListener('change', function(){
    fetch('./division-json/postcodes.json')
    .then(response => {
        return response.json();
    }).then(data => {
        const thanaArray = [];
        for(let i=0; i < data.postcodes.length; i++){
            const districtName = data.postcodes[i]['district'];
            const thanaName = data.postcodes[i]['thana'];
            if(districtName === this.value){
                if(!thanaArray.includes(thanaName)){
                    thanaArray.push(thanaName)
                }
            }
        }

        const thanaElement = document.querySelector('#thana');
        clearOptions("thana");
        thanaArray.forEach(element => {
            const option = document.createElement('option');
            option.value = element;
            option.innerHTML = element;
            thanaElement.appendChild(option);
        })
    })
});
const thanaElement = document.querySelector('#thana');
thanaElement.addEventListener('change', function(){
    fetch('./division-json/postcodes.json')
    .then(response => {
        return response.json();
    }).then(data => {
        const postOfficeArray = [];
        for(let i=0; i < data.postcodes.length; i++){
            const thanaName = data.postcodes[i]['thana'];
            const postOfficeName = data.postcodes[i]['postOffice'];
            if(thanaName === this.value){
                if(!postOfficeArray.includes(postOfficeName)){
                    postOfficeArray.push(postOfficeName)
                }
            }
        }

        const postOfficeElement = document.querySelector('#postOffice');
        clearOptions("postOffice");
        postOfficeArray.forEach(element => {
            const option = document.createElement('option');
            option.value = element;
            option.innerHTML = element;
            postOfficeElement.appendChild(option);
        })
    })
});
const postOfficeElement = document.querySelector('#postOffice');
postOfficeElement.addEventListener('change', function(){
    fetch('./division-json/postcodes.json')
    .then(response => {
        return response.json();
    }).then(data => {
        const postCodeArray = [];
        for(let i=0; i < data.postcodes.length; i++){
            const postOfficeName = data.postcodes[i]['postOffice'];
            const postCodeName = data.postcodes[i]['postCode'];
            if(postOfficeName === this.value){
                if(!postCodeArray.includes(postCodeName)){
                    postCodeArray.push(postCodeName)
                }
            }
        }

        const postCodeElement = document.querySelector('#postCode');
        clearOptions("postCode");
        postCodeArray.forEach(element => {
            const option = document.createElement('option');
            option.value = element;
            option.innerHTML = element;
            postCodeElement.appendChild(option);
        })
    })
});
function clearOptions(id){
     document.querySelector('#'+id).innerHTML = '';
}

