import styled from "styled-components";


const BasicTitle = styled.h1`
text-align: center;
text-transform: capitalize;
`;

const DefaultButton = styled.button`
  background: lightblue;
  color:black;
  border: none;
  border-radius: 0.25rem;  
  cursor: pointer;
  text-transform: capitalize;
  padding: 0.25rem;
  display: block;
  width: 200px;
  margin: 1rem auto;

  box-shadow: 0 0 0.3em black;
`;

function App() {
  return (
    <div style={{padding: '2rem'}}>
        <BasicTitle>styled component</BasicTitle>
        <DefaultButton className="btn">click me</DefaultButton>

    </div>
  );
}

export default App;
