import styled from "styled-components";

const BackTitle = styled.div`
border: 0;
box-shadow: 1px 1px 1px 1px black;
margin-left:25em;
width:50%;
display:flex;
justify-content: space-between;
`;


const Title = styled.h3`
color:red;
padding: 1em;
padding-left: 3em;
text-align: left;
`;

const Title3 = styled.h3`
color:red;
padding: 1em;
padding-right: 3em;
text-align: right;

`;


function App() {
  return (
    <div>
     <BackTitle>
       <Title>styled components</Title>
       <Title3>styled components</Title3>
     </BackTitle>

    </div>
  );
}

export default App;
